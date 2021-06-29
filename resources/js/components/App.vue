<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div>
                    <div class="card mb-2">
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <p class="col-3 mb-0 ml-4">fio</p>
                            <p class="col-3 mb-0">auto</p>
                            <p class="col-2 text-center mb-0">number</p>
                            <div class="col-4 text-right">
                                <button class="btn btn-primary">Редактировать</button>
                                <button class="btn btn-danger ml-2">Удалить</button>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-2">
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <p class="col-3 mb-0 ml-4">fio</p>
                            <p class="col-3 mb-0">auto</p>
                            <p class="col-2 text-center mb-0">number</p>
                            <div class="col-4 text-right">
                                <button class="btn btn-primary">Редактировать</button>
                                <button class="btn btn-danger ml-2">Удалить</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="pagination">
                    <div class="d-flex align-items-center">
                        <div class="mr-2 pagination__btn pagination__btn-prev">Назад</div>
                        <div class="mr-2 pagination__btn-number">4</div>
                        <div class="mr-2 pagination__btn-number pagination__btn-number__active">5</div>
                        <div class="mr-2 pagination__btn-number">6</div>
                        <div class="pagination__btn pagination__btn-next">Вперед</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {

        },

        methods : {

            editClient(record_id){

            },

            removeClientAuto(record_id){

            },

            changePage(page_number){

            },

            nextPage(){

            },

            prevPage(){

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
