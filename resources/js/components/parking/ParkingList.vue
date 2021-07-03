<template>
    <div>
        <div >
            <h1 class="mb-4">Парковка</h1>
        </div>
        <div class="mb-4 text-left d-flex mt-4">
            <div class="col-2 pl-0">
                <multiselect
                    v-model="form.client"
                    label="name"
                    track-by="code"
                    placeholder=""
                    :options="clients_options"
                    :searchable="true"
                    :show-labels="false"
                    :close-on-select="true"
                    @input="resetCarsSelects"
                />
                <p class="mb-0 mu-title">Клиент</p>
            </div>

            <div class="ml-3 col-2 pl-0" v-if="this.form.client != null">
                <multiselect
                    v-model="form.car"
                    label="name"
                    track-by="code"
                    placeholder=""
                    :options="clients_cars_options[this.form.client.code]"
                    :searchable="true"
                    :show-labels="false"
                    :close-on-select="true"
                    @input="showPlacedBtn"
                />
                <p class="mb-0 mu-title">Авто</p>
            </div>


            <button class="btn btn-primary ml-3" @click="bindPlaceClientCar(form.client.code, form.car.code)" v-if="change_car_laceed_name != null">{{change_car_laceed_name}}</button>
        </div>
        <div>
            <div class="card mb-2" v-for="(parked_car, index) in parked_cars" v-bind:class="{'placed_car_card': parked_car.placed, 'not_placed_car_card' : !parked_car.placed}">
                <div class="card-body d-flex align-items-center justify-content-center">
                    <p class="col-3 mb-0 ml-4">{{ parked_car.second_name + ' ' + parked_car.first_name + ' ' + parked_car.third_name }}</p>
                    <p class="col-3 mb-0">{{ parked_car.brand + ' / ' + parked_car.model }}</p>
                    <p class="col-2 text-center mb-0">{{ parked_car.license_plate }}</p>
                    <div class="col-4 text-right" >
                        <button class="btn " v-bind:class="{ 'btn-secondary' : parked_car.placed,  'btn-success' : !parked_car.placed }" @click="changeCarPlacedStatus(parked_car.id, parked_car.car_id, parked_car.placed)">{{ parked_car.placed ? 'Вывести' : 'Разместить'}}</button>
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>

<script>
export default {
    name: "ParkingList",
    data(){
        return {
            errors : null,

            clients_options : [],
            clients_cars_options : [],

            parked_cars : [],
            parked_cars_count : 0,


            form : {
                client : null,
                car : null
            },

            change_car_laceed_name : null

        }
    },

    created() {
        this.getAllCars();
        this.getAllClients();
    },

    methods : {

        //Получение всех машин на парковке
        getAllCars(){
            axios.get('/parked_cars_list')
                .then(response=>{
                    if(response.data.success){
                        this.errors = null;
                        this.parked_cars = response.data.data;
                    }
                    else{
                        this.errors = response.data.errors;
                    }
                });
        },

        getAllClients(){
            axios.get('/get_all_clients')
                .then(response=>{
                    if(response.data.success){

                        this.clients_options = [];

                        $.each(response.data.data, (index, v)=>{
                           this.clients_options.push({ name : v.second_name + ' ' + v.first_name + ' ' + v.third_name , code : v.id});

                            this.clients_cars_options[v.id] = [];

                           $.each(this.parked_cars, (i, car) => {
                               if(car.owner == car.id )
                                   this.clients_cars_options[v.id].push( { name: car.model + '/' + car.brand, code : car.car_id, car_status : car.placed});
                           });
                        });
                    }
                    else{
                        this.errors = response.data.errors;
                    }
                });
        },

        changeCarPlacedStatus(client_id, car_id, status){
            let place_url = '';
            if(!status)
                place_url = '/place_client_car';
            else
                place_url = '/replace_client_car';

            axios.post(place_url, { client_id : client_id, car_id : car_id})
                .then(response=>{
                    if(response.data.success){
                        this.errors = null;
                        this.getAllCars();
                        this.getAllClients();
                        this.resetCarsSelects();
                        this.form.car = null;
                        this.change_car_laceed_name = null;
                    }
                    else{
                        this.errors = response.data.errors;
                    }
                });
        },

        bindPlaceClientCar(client_id, car_id){

            let place_url = '';
            if(!this.form.car.car_status)
                place_url = '/place_client_car';
            else
                place_url = '/replace_client_car';

            axios.post(place_url, { client_id : client_id, car_id : car_id})
                .then(response=>{
                   if(response.data.success){
                       this.errors = null;
                       this.getAllCars();
                       this.getAllClients();
                       this.resetCarsSelects();
                       this.form.car = null;
                       this.change_car_laceed_name = null;

                       //this.form.car.car_status = !this.form.car.car_status;

                       //this.showPlacedBtn();
                   }
                   else{
                       this.errors = response.data.errors;
                   }
                });


        },

        resetCarsSelects(){
            this.form.car = null;
        },

        showPlacedBtn(){
            if(this.form.client != null && this.form.car!=null){
                if(this.form.car.car_status){
                    this.change_car_laceed_name = 'Вывести';
                }
                else{
                    this.change_car_laceed_name = 'Разместить';
                }

            }
        },


    }
}
</script>

<style scoped>
/*
Items list style
*/

.placed_car_card{
    border: 1px solid #28a745;
}

.not_placed_car_card{
    background-color: #80808021;
}

/*
Input label
*/
.mu-title{
    position: absolute;
    top: -9px;
    left: 13px;
    font-size: 14px;
    color: #a7a7a7;
    background-color: white;
}


</style>
