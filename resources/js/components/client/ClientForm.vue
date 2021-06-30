<template>
    <div>
        <div class="alert alert-danger" v-if="errors" >
            <div v-for="category in errors">
                <p class="mb-0" v-for="error in category">{{error}}</p>
            </div>
        </div>
        <div class="alert alert-success" v-if="success_added">
            <p class="mb-0">{{success_message}}</p>
        </div>
        <div class="d-flex">
            <div class="d-flex flex-column col-6">
                <div class="d-flex">
                    <p class="mb-0 align-self-center form-field__item-name w-25">Фамилия</p>
                    <input class="form-control ml-2 w-75" v-bind:class="{'is-invalid' : errors != null && errors.second_name != undefined && errors.second_name.length > 0}" v-model="form.second_name" required/>
                </div>
                <div class="d-flex mt-2">
                    <p class="mb-0 align-self-center form-field__item-name w-25">Имя</p>
                    <input class="form-control ml-2 w-75" v-bind:class="{'is-invalid' : errors != null && errors.first_name != undefined && errors.first_name.length > 0}" v-model="form.first_name" required/>
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
                    <input class="form-control ml-2 w-75" v-bind:class="{'is-invalid' : errors != null && errors.phone != undefined && errors.phone.length > 0}" v-model="form.phone" required/>
                </div>
                <div class="d-flex mt-2">
                    <p class="mb-0 align-self-center form-field__item-name w-25">Адрес</p>
                    <input class="form-control ml-2 w-75" v-bind:class="{'is-invalid' : errors != null && errors.address != undefined && errors.address.length > 0}" v-model="form.address" required/>
                </div>
            </div>
        </div>
        <button class="btn btn-primary mt-4" @click="btnReactionSwitcher">Сохранить</button>
    </div>
</template>

<script>
export default {
    name: "ClientForm",

    data(){
        return {
            form : {
                first_name : null,
                second_name : null,
                third_name : null,
                gender : 0,
                phone : null,
                address : null
            },
            errors : null,
            success_added : false,
            success_message : 'Клиент успешно добавлен! Теперь вы можете добавить к клиенту его машины.',
            component_mode : 'create',


        }
    },

    mounted() {
        if(this.component_mode == 'edit'){
            this.success_message = 'Клиент успешно отредактирован!'
        }
    },

    methods : {
        saveClientPersonalData(){
            //Отправка данных на запись
            axios.post('/create_client', this.form)
                .then( response=>{
                    if(response.data.success) {
                        //Отправка события об успешном добавлении пользователя
                        this.$emit('savedClientPersonalData', );
                        this.errors = null;
                        this.success_added = true;
                        this.component_mode = 'edit';
                    }
                    else{
                        this.errors = response.data.errors;
                    }

            });
        },

        editClientPersonalData(){
          //редактирование клиента
        },

        btnReactionSwitcher(){
            //Переключение поведения компонента
            switch (this.component_mode){
                case 'create' : {
                    this.saveClientPersonalData()
                }

                case 'edit' : {
                    this.editClientPersonalData();
                }
            }
        }
    }

}
</script>

<style scoped>
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
</style>
