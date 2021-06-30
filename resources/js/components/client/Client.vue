<template>
<div>
    <h1 class="mb-4">Добавление клиента</h1>
    <client_form
        @savedClientPersonalData="getAssessToAddCars"
    ></client_form>
    <div v-if="can_add_cars">
        <car_form ></car_form>
    </div>
</div>
</template>

<script>
export default {
    name: "Client",

    data() {
        return {
            can_add_cars : false,

        }
    },

    mounted() {


    },

    methods : {
        getAssessToAddCars(){
            this.can_add_cars = true;
        }
    }
}
</script>

<style scoped>

</style>
