<template>
    <div>
        <div class="d-flex mb-4 align-items-center">
            <h1 class="col-2 pl-0">Все клиенты</h1>
            <div class="col-2 offset-8 text-right pr-0">
                <router-link class="btn btn-info" to="/parking_list">Войти на парковку</router-link>
            </div>
        </div>
        <div class="mb-4 text-left">
            <button class="btn btn-primary" @click="createClient">+ Добавить клиента</button>
        </div>
        <div>
            <div class="card mb-2" v-for="(client, index) in clients">
                <div class="card-body d-flex align-items-center justify-content-center">
                    <p class="col-3 mb-0 ml-4">{{ client.second_name + ' ' + client.first_name + ' ' + client.third_name }}</p>
                    <p class="col-3 mb-0">{{ client.brand + ' / ' + client.model }}</p>
                    <p class="col-2 text-center mb-0">{{ client.license_plate }}</p>
                    <div class="col-4 text-right">
                        <button class="btn btn-primary" @click="editClient(client.id)">Редактировать</button>
                        <button class="btn btn-danger ml-2" @click="removeClientAuto(client.id, client.car_id, index)">Удалить</button>
                    </div>
                </div>
            </div>

        </div>
        <div id="pagination" v-if="clients.length > 0">
            <div class="d-flex align-items-center">
                <div class="mr-2 pagination__btn pagination__btn-prev" @click="prevPage">Назад</div>
                <div class="mr-2 pagination__btn-number" @click="changePage(pagination.btns.prev_prev)" v-if="pagination.pages > 0" v-bind:class="{'pagination__btn-number__active' : this.pagination.current_page == 1}">{{this.pagination.btns.prev_prev}}</div>
                <div class="mr-2 pagination__btn-number" @click="changePage(pagination.btns.prev)" v-if="pagination.pages > 1" v-bind:class="{'pagination__btn-number__active' : this.pagination.current_page == 2}">{{this.pagination.btns.prev}}</div>
                <div class="mr-2 pagination__btn-number" @click="changePage(pagination.btns.cur)" v-if="pagination.pages > 2" v-bind:class="{'pagination__btn-number__active' : this.pagination.current_page == this.pagination.btns.cur  }">{{this.pagination.btns.cur}}</div>
                <div class="mr-2 pagination__btn-number" @click="changePage(pagination.btns.next)" v-if="pagination.pages > 3" v-bind:class="{'pagination__btn-number__active' : this.pagination.current_page == this.pagination.pages - 1 && this.pagination.pages !=4 || this.pagination.pages == 4 && this.pagination.current_page == this.pagination.pages}">{{this.pagination.btns.next}}</div>
                <div class="mr-2 pagination__btn-number" @click="changePage(pagination.btns.next_next)" v-if="pagination.pages > 4" v-bind:class="{'pagination__btn-number__active' : this.pagination.current_page == this.pagination.pages }">{{this.pagination.btns.next_next}}</div>
                <div class="pagination__btn pagination__btn-next" @click="nextPage">Вперед</div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                clients : [],
                errors : null,

                pagination : {
                    page_item_limit : 2,
                    pages : 2,
                    current_page : 1,
                    btns : {
                        prev_prev : null,
                        prev : null,
                        cur : null,
                        next : null,
                        next_next : null
                    }
                }
            }
        },

        mounted() {
            this.getClients();
        },

        methods : {

            getClients(){

                axios.get('/get-cars-count')
                    .then(response=>{
                        if(response.data.success){
                            this.pagination.pages = Math.ceil(response.data.cars_count / this.pagination.page_item_limit) ;

                            if(this.$route.query.page < 1 || !this.$route.query.page){
                                this.pagination.current_page = 1;
                                this.$router.push('/?page=1')
                            }
                            else if(this.$route.query.page > this.pagination.pages) {
                                this.pagination.current_page = this.pagination.pages;
                                this.$router.push('/?page=' + this.pagination.pages)
                            }
                            else
                                this.pagination.current_page = parseInt(this.$route.query.page);



                            if(this.pagination.current_page > this.pagination.pages )
                                this.pagination.current_page = this.pagination.pages;

                            if(this.pagination.current_page < 1)
                                this.pagination.current_page = 1;

                            axios.post('/clients_list', { 'offset' : (this.pagination.current_page - 1) * this.pagination.page_item_limit , 'limit' : this.pagination.page_item_limit} )
                                .then( response=>{
                                    this.clients = response.data.data;
                                });

                            if(this.pagination.current_page <= 3){
                                this.pagination.btns.prev_prev = 1;
                                this.pagination.btns.prev = 2;
                                this.pagination.btns.cur = 3;
                                this.pagination.btns.next = 4;
                                this.pagination.btns.next_next = 5;
                            }
                            else if (this.pagination.pages - this.pagination.current_page >2){
                                this.pagination.btns.prev_prev = this.pagination.current_page - 2;
                                this.pagination.btns.prev = this.pagination.current_page - 1;
                                this.pagination.btns.cur = this.pagination.current_page;
                                this.pagination.btns.next = this.pagination.current_page + 1;
                                this.pagination.btns.next_next = this.pagination.current_page + 2;
                            }
                            else if (this.pagination.pages - this.pagination.current_page == 2){
                                this.pagination.btns.prev_prev = this.pagination.current_page - 2;
                                this.pagination.btns.prev = this.pagination.current_page - 1;
                                this.pagination.btns.cur = this.pagination.current_page;
                                this.pagination.btns.next = this.pagination.current_page + 1;
                                this.pagination.btns.next_next = this.pagination.current_page + 2;
                            }
                            else if (this.pagination.pages - this.pagination.current_page == 1){
                                this.pagination.btns.prev_prev = this.pagination.current_page - 3;
                                this.pagination.btns.prev = this.pagination.current_page - 2;
                                this.pagination.btns.cur = this.pagination.current_page - 1;
                                this.pagination.btns.next = this.pagination.current_page;
                                this.pagination.btns.next_next = this.pagination.current_page + 1;
                            }
                            else if (this.pagination.pages - this.pagination.current_page == 0 && this.pagination.pages == 4){
                                this.pagination.btns.prev_prev = this.pagination.current_page - 3;
                                this.pagination.btns.prev = this.pagination.current_page - 2;
                                this.pagination.btns.cur = this.pagination.current_page - 1;
                                this.pagination.btns.next = this.pagination.current_page;
                                this.pagination.btns.next_next = this.pagination.current_page + 1;
                            }
                            else if (this.pagination.pages - this.pagination.current_page == 0){
                                this.pagination.btns.prev_prev = this.pagination.current_page - 4;
                                this.pagination.btns.prev = this.pagination.current_page - 3;
                                this.pagination.btns.cur = this.pagination.current_page - 2;
                                this.pagination.btns.next = this.pagination.current_page - 1;
                                this.pagination.btns.next_next = this.pagination.current_page;
                            }
                        }
                        else{
                            console.log(response.data);
                        }

                    });

            },

            createClient(){
                this.$router.push('/create_client');
            },

            editClient(record_id){
                this.$router.push('/edit_client/client/' + record_id);
            },

            removeClientAuto(client_id, car_id, record_id){
                axios.post('/remove_car', { client_id : client_id, car_id : car_id })
                    .then(response=>{
                       if(response.data.success){
                           this.getClients();
                       }
                    });
            },

            changePage(page_number){
                console.log(this.pagination)
                if(page_number != this.pagination.current_page){
                    this.pagination.current_page = page_number;
                    this.$router.push('/?page=' + page_number);
                    this.getClients();
                }

            },

            nextPage(){
                if(this.pagination.pages > this.pagination.current_page){
                    this.pagination.current_page++;
                    this.$router.push('/?page=' + this.pagination.current_page);
                    this.getClients();
                }
            },

            prevPage(){
                if(this.pagination.current_page != 1){
                    this.pagination.current_page--;
                    this.$router.push('/?page=' + this.pagination.current_page);
                    this.getClients();
                }
            }
        }
    }
</script>

<style scoped>
/*
Pagination block styles
*/

#pagination{
    margin-top: 30px;
}

.pagination__btn{
    border-radius: 20px;
    padding: 6px 15px;
    width: 90px;
    text-align: center;
    cursor: pointer;
}

.pagination__btn-prev{
    border: 1px solid #9a9a9a1f;
    background-color: #cbc8c840;
    color: black;
}

.pagination__btn-next{
    background-color: #004085;
    color: white;
}

.pagination__btn-number{
    border-radius: 50%;
    background-color: #cbc8c840;
    color: black;
    padding: 4px 10px;
    cursor: pointer;
    width: 40px;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.pagination__btn-number.pagination__btn-number__active{
    background-color: #004085;
    color: white;
}
</style>
