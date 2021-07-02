<template>
<div>
    <h1 class="mb-5">Добавление клиента</h1>
    <div>
        <h3 class="mb-4 mt-5">Персональные данные</h3>
        <div>
            <div class="alert alert-danger" v-if="errors != null && errors.client != undefined && errors.client" >
                <div v-for="category in errors.client">
                    <p class="mb-0" v-for="error_p in category">{{error_p}}</p>
                </div>
            </div>
            <div class="alert alert-success" v-if="success_added">
                <p class="mb-0">{{success_message}}</p>
            </div>
            <div class="d-flex">
                <div class="d-flex flex-column col-6 pl-0">
                    <div class="d-flex">
                        <p class="mb-0 align-self-center form-field__item-name w-25">Фамилия</p>
                        <input class="form-control ml-2 w-75" v-bind:class="{'is-invalid' : errors != null && errors.client != undefined && errors.client.second_name != undefined && errors.client.second_name.length > 0}" v-model="form.second_name" required/>
                    </div>
                    <div class="d-flex mt-2">
                        <p class="mb-0 align-self-center form-field__item-name w-25">Имя</p>
                        <input class="form-control ml-2 w-75" v-bind:class="{'is-invalid' : errors != null && errors.client != undefined && errors.client.first_name != undefined && errors.client.first_name.length > 0}" v-model="form.first_name" required/>
                    </div>
                    <div class="d-flex mt-2">
                        <p class="mb-0 align-self-center form-field__item-name w-25">Отчество</p>
                        <input class="form-control ml-2 w-75" v-model="form.third_name"/>
                    </div>
                </div>
                <div class="d-flex flex-column col-6">
                    <div class="d-flex form-field__radio-size">
                        <p class="mb-0 align-self-center form-field__item-name w-25">Пол</p>
                        <div class="d-flex w-75">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">М</p>
                                <input type="radio" class="form-control ml-2 form-field__item-radio" value="0" id="gender_m" v-model="form.gender"/>
                            </div>
                            <div class="d-flex align-items-center pl-2">
                                <p class="mb-0">Ж</p>
                                <input type="radio" class="form-control ml-2 form-field__item-radio" value="1" id="gender_w" v-model="form.gender" />
                            </div>
                        </div>
                    </div>

                    <div class="d-flex mt-2">
                        <p class="mb-0 align-self-center form-field__item-name w-25">Телефон</p>
                        <input class="form-control ml-2 w-75" v-bind:class="{'is-invalid' : errors != null && errors.client != undefined && errors.client.phone != undefined && errors.client.phone.length > 0}" v-model="form.phone" required/>
                    </div>
                    <div class="d-flex mt-2">
                        <p class="mb-0 align-self-center form-field__item-name w-25">Адрес</p>
                        <input class="form-control ml-2 w-75" v-bind:class="{'is-invalid' : errors != null && errors.client != undefined && errors.client.address != undefined && errors.client.address.length > 0}" v-model="form.address" required/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <h3 class="mb-4 mt-5">Данные авто</h3>
        <div class="alert alert-danger" v-if="errors != null && errors.cars != undefined && errors.cars.length > 0">
            <p class="mb-0" v-for="(car_error, index) in errors.cars">
                Проверьте правильность заполнения данных в автомобиле # {{ parseInt(index) + 1}}
            </p>
        </div>
        <div class="alert alert-danger" v-if="errors != null && errors.cars_duplicate_groups != undefined && errors.cars_duplicate_groups.length > 0">
            <p class="mb-0" v-for="(cars_duplicate_group, index) in errors.cars_duplicate_groups">
                Найдены дубликаты гос. номеров в автомобилях:
                <span class="d-flex flex-column">
                    <span v-for="dublicate_car in cars_duplicate_group">#{{parseInt(dublicate_car) + 1}}</span>
                </span>
            </p>
        </div>
        <div class="mt-4 d-flex flex-wrap">
            <div class="col-6 pl-2 pr-2 mb-3 position-relative" v-for="(car,i) in form.cars">
                <div class="add-car__template flex-column">
                    <div class="d-flex w-100 justify-content-center">
                        <div class="col-6">
                            <!-- Модели авто, использовать, если есть данные в бд
                            <multiselect
                                v-model="form.cars[i]"
                                label="name"
                                track-by="code"
                                placeholder=""
                                :options="cars.marks"
                                :searchable="false"
                                :show-labels="false"
                                :close-on-select="true"

                            />
                            -->
                            <input class="form-control" v-model="form.cars[i].brand" v-bind:class="{'is-invalid' : errors != null && errors.cars != undefined && errors.cars[i] != undefined  && errors.cars[i].brand != undefined && errors.cars[i].brand.length > 0}" />
                            <p class="mb-0 mu-title">Марка</p>
                        </div>
                        <div class="col-6">
                            <!-- Модели авто, использовать, если есть данные в бд
                            <multiselect
                                v-model="form.cars[i]"
                                label="name"
                                track-by="code"
                                placeholder=""
                                :options="cars.models"
                                :searchable="false"
                                :show-labels="false"
                                :close-on-select="true"
                            />
                            -->
                            <input class="form-control" v-model="form.cars[i].model" v-bind:class="{'is-invalid' : errors != null && errors.cars != undefined && errors.cars[i] != undefined  && errors.cars[i].model != undefined && errors.cars[i].model.length > 0}"/>
                            <p class="mb-0 mu-title">Модель</p>
                        </div>
                    </div>
                    <div class="d-flex w-100 justify-content-center mt-4">
                        <div class="col-6">
                            <input class="form-control" v-model="form.cars[i].color" v-bind:class="{'is-invalid' : errors != null && errors.cars != undefined && errors.cars[i] != undefined  && errors.cars[i].color != undefined && errors.cars[i].color.length > 0}"/>
                            <p class="mb-0 mu-title">Цвет кузова</p>
                        </div>
                        <div class="col-6">
                            <input class="form-control" v-model="form.cars[i].license_plate" v-bind:class="{'is-invalid' : errors != null && errors.cars != undefined && errors.cars[i] != undefined  && errors.cars[i].license_plate != undefined && errors.cars[i].license_plate.length > 0 || errors != null && errors.cars_duplicate_numbers != null && errors.cars_duplicate_numbers.indexOf(i) != -1}"/>
                            <p class="mb-0 mu-title">Гос Номер РФ</p>
                        </div>
                    </div>

                </div>
                <div class="add-car__template-number">#{{i+1}}</div>
                <div class="remove-car-template-btn" v-if="form.cars.length > 1" @click="removeCarTemplate(i)">&#x2718;</div>
            </div>

            <div id="car-add-btn" class="col-6 pl-2 pr-2 mb-3" @click="add_car">
                <div class="add-car__template add-car__template-btn">
                    <p class="mb-0 add-car__template-title">Добавить машину +</p>
                </div>
            </div>
        </div>
    </div>

    <button class="btn btn-primary mt-4" @click="btnReactionSwitcher">Сохранить</button>
</div>
</template>

<script>
export default {
    name: "Client",

    data() {
        return {
            form : {
                first_name : null,
                second_name : null,
                third_name : null,
                gender : 0,
                phone : null,
                address : null,
                cars : [
                    {
                        'brand' : null,
                        'model' : null,
                        'color' : null,
                        'license_plate' : null
                    }
                ],
            },
            errors : null,
            success_added : false,
            success_messages : 'Клиент успешно добавлен! Теперь вы можете добавить к клиенту его машины.',
            component_mode : 'create',

            cars : {
                models : [

                    ],
                marks : [
                    {'name': 'Opel' , 'code' : 1},
                    {'name': 'Skoda' , 'code' : 2},
                ]
            },

            cars_forms : [

            ],
            cars_count : 0
        }
    },

    mounted() {


    },

    created() {
        if(this.$route.params.client_id){
            this.component_mode = 'edit';

            axios.post('/get_client_data', { client_id : parseInt(this.$route.params.client_id)})
                .then(response=>{
                    if(response.data.success){
                        this.form.first_name = response.data.data.client_personal_data.first_name;
                        this.form.second_name = response.data.data.client_personal_data.second_name;
                        this.form.third_name = response.data.data.client_personal_data.third_name;
                        this.form.gender = response.data.data.client_personal_data.gender;
                        this.form.phone = response.data.data.client_personal_data.phone;
                        this.form.address = response.data.data.client_personal_data.address;

                        this.form.cars.splice(0,1);

                        for(var i=0; i < response.data.data.client_cars.length; i++){
                            this.form.cars.push({
                                'brand' : response.data.data.client_cars[i].brand,
                                'model' : response.data.data.client_cars[i].model,
                                'color' : response.data.data.client_cars[i].color,
                                'license_plate' : response.data.data.client_cars[i].license_plate
                            });
                        }
                    }
                    else{
                        console.log(response.data.errors);
                    }
                });
        }
    },

    methods : {

        saveClient(){
            this.success_added = false;
            this.errors = null;

            axios.post('/create_client', this.form)
                .then( response=>{
                    if(response.data.success) {
                        //Отправка события об успешном добавлении пользователя
                        this.$emit('savedClientPersonalData', );
                        this.$router.push('/');
                    }
                    else{
                        this.errors = response.data.errors;

                        console.log(this.errors)

                        if(this.errors != null && this.errors.cars_duplicate_groups != undefined && this.errors.cars_duplicate_groups.length > 0){

                            let dublicates_arr = [];

                            $.each(this.errors.cars_duplicate_groups, (index) =>{
                                dublicates_arr = dublicates_arr.concat(this.errors.cars_duplicate_groups[index]);
                            });

                            this.errors.cars_duplicate_numbers = dublicates_arr;
                        }
                    }

                });
        },

        editClient(){
            axios.post('/edit_client', this.form)
            .then(response=>{
                if(response.data.success){
                    console.log(response.data)
                }
                else{

                }
            });
        },

        btnReactionSwitcher(){
            //Переключение поведения компонента
            switch (this.component_mode){
                case 'create' : {
                    this.saveClient()
                }

                case 'edit' : {
                    this.editClient();
                }
            }
        },

        add_car(){
            this.form.cars.push(
                {
                    'brand' : null,
                    'model' : null,
                    'color' : null,
                    'license_plate' : null
                }
            );

            console.log(this.form.cars)
        },

        removeCarTemplate(index){
            this.form.cars.splice(index,1);
            if( this.errors != null && this.errors.cars != undefined && this.errors.cars[index] != undefined ){
                this.errors.cars.splice(index,1);
            }
        }
    }
}
</script>

<style scoped>

/* Форма персональныйх данных*/
.form-field__radio-size{
    height: 38px;
}

.form-field__item-name{
    font-size: 18px;
}

.form-field__item-radio{
    width: 20px;
    height: 20px;
}

/* Карточка добавления новой машины*/
.add-car__template{
    border: 3px solid #345bea30;
    border-radius: 10px;
    min-height: 200px;
    width: 100%;
    display: flex;
    padding-top: 20px;
    padding-bottom: 20px;
    justify-content: center;
}

.add-car__template-btn{
    cursor: pointer;
    align-items: center;
}

.add-car__template-title{
    font-size: 20px;
    color: #345bea85;
}

.add-car__template-number{
    position: absolute;
    top: 0;
    font-size: 25px;
    left: 25px;
}

.remove-car-template-btn{
    position: absolute;
    top: 0;
    font-size: 25px;
    right: 16px;
    color: red;
    cursor: pointer;
}


/* Мультиселектор */
.mu-title{
    position: absolute;
    top: -9px;
    left: 25px;
    font-size: 14px;
    color: #a7a7a7;
    background-color: white;
}

/* Инпут */
input{
    border: 1px solid #e8e8e8;
}

.form-control:focus{
    box-shadow: unset;
    border-color: #007bff;
}


</style>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>
.multiselect__option--highlight:hover {
    background: #00365a!important;
    color: white !important;
}

.multiselect__option--highlight:hover:after {
    background: #00365a!important;
    color: white !important;
}

.multiselect__option--highlight {
    background: white !important;
    color: #3a3a3a !important;
}
</style>
