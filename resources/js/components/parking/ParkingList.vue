<template>
    <div>
        <div >
            <h1 class="mb-4">Парковка</h1>
        </div>
        <div class="mb-4 text-left d-flex mt-4">
            <div class="col-2">
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
            </div>

            <div class="ml-3 col-2 pl-0">
                <multiselect v-if="this.form.client != null"
                    v-model="form.car"
                    label="name"
                    track-by="code"
                    placeholder=""
                    :options="clients_cars_options[this.form.client.code]"
                    :searchable="true"
                    :show-labels="false"
                    :close-on-select="true"

                />
            </div>


            <button class="btn btn-primary ml-3" @click="placeClientCar(form.client_id, form.car_id)">Разместить</button>
        </div>
        <div>
            <div class="card mb-2" v-for="(parked_car, index) in parked_cars">
                <div class="card-body d-flex align-items-center justify-content-center">
                    <p class="col-3 mb-0 ml-4">{{ parked_car.second_name + ' ' + parked_car.first_name + ' ' + parked_car.third_name }}</p>
                    <p class="col-3 mb-0">{{ parked_car.brand + ' / ' + parked_car.model }}</p>
                    <p class="col-2 text-center mb-0">{{ parked_car.license_plate }}</p>
                    <div class="col-4 text-right">
                        <button class="btn btn-success" @click="changeCarPlacedStatus(parked_car.car_id)">Разместить</button>
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
            }

        }
    },

    created() {

        this.clients_options.push({ name : 'Акакий', code : 1 });
        this.clients_options.push({ name : 'Марина', code : 2 });

        this.clients_cars_options[1] = [];
        this.clients_cars_options[2] = [];

        this.clients_cars_options[1].push( { name : 'Lexus', code : 1 } );
        this.clients_cars_options[1].push( { name : 'Заз', code : 2 } );
        this.clients_cars_options[2].push( { name : 'Nissan', code : 3 } );
        this.clients_cars_options[2].push( { name : 'Ваз', code : 4 } );
        this.clients_cars_options[2].push( { name : 'Cherry', code : 5 } );

        console.log(this.clients_options);
        console.log(this.clients_cars_options);
    },

    methods : {

        //Получение всех машин на парковке
        getAllParkedCars(){
            axios.get('/parked_cars_list')
                .then(response=>{
                    if(response.data.success){
                        this.errors = null;

                    }
                    else{
                        this.errors = response.data.errors;
                    }
                });
        },

        changeCarPlacedStatus(car_id){
            axios.post('/change_car_placed_status', { car_id : car_id})
                .then(response=>{
                    if(response.data.success){
                        this.errors = null;

                    }
                    else{
                        this.errors = response.data.errors;
                    }
                });
        },

        placeClientCar(client_id, car_id){

            console.log(this.form.client.code)

            axios.post('/place_client_car', { client_id : client_id, car_id : car_id })
                .then(response=>{
                   if(response.data.success){
                       this.errors = null;
                   }
                   else{
                       this.errors = response.data.errors;
                   }
                });


        },

        resetCarsSelects(){
            this.form.car = null;
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
