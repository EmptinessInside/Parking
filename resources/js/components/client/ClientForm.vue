<template>
    <div>
        <div class="d-flex">
            <div class="d-flex col-4">
                <p class="mb-0 align-self-center form-field__item-name">Фамилия</p>
                <input class="form-control ml-2" v-model="form.second_name" required/>
            </div>
            <div class="d-flex col-4 pl-4">
                <p class="mb-0 align-self-center form-field__item-name">Имя</p>
                <input class="form-control ml-2" v-model="form.first_name" required/>
            </div>
            <div class="d-flex col-4 pl-4">
                <p class="mb-0 align-self-center form-field__item-name">Отчество</p>
                <input class="form-control ml-2" v-model="form.third_name"/>
            </div>
        </div>
        <div class="d-flex mt-4">
            <div class="d-flex col-2">
                <p class="mb-0 align-self-center form-field__item-name">Пол</p>
                <div class="pl-4 d-flex">
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
            <div class="d-flex col-4 pl-4">
                <p class="mb-0 align-self-center form-field__item-name">Телефон</p>
                <input class="form-control ml-2" v-model="form.phone" required/>
            </div>
            <div class="d-flex col-6 pl-4">
                <p class="mb-0 align-self-center form-field__item-name">Адрес</p>
                <input class="form-control ml-2" v-model="form.address" required/>
            </div>
        </div>
        <button @click="saveClientPersonalData">Сохранить</button>
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
            }
        }
    },

    mounted() {

    },

    methods : {
        saveClientPersonalData(){
            //Отправка данных на запись
            axios.post('/create_client', this.form)
                .then( response=>{
                    if(response.data.success) {
                        //Отправка события об успешном добавлении пользователя
                        this.$emit('savedClientPersonalData', );
                    }
                    else{
                        console.log(response.data.errors)
                    }

            });



        }
    }

}
</script>

<style scoped>
    .form-field__item-name{
        font-size: 18px;
    }

    .form-field__item-radio{
        width: 20px;
        height: 20px;
    }
</style>
