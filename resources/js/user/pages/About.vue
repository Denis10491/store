<template>
    <div class="uk-card uk-card-default uk-padding border">
        <div>
            <ul uk-tab>
                <li :class="{'uk-active': menu.cards}"><a @click="changeTab('en')" href="#">en</a></li>
                <li :class="{'uk-active': menu.table}"><a @click="changeTab('ru')" href="#">ru</a></li>
                <li :class="{'uk-active': menu.create}"><a @click="changeTab('stack')" href="#">stack</a></li>
                <li :class="{'uk-active': menu.features}"><a @click="changeTab('features')" href="#">features</a></li>
            </ul>
        </div>

        <div v-if="menu.en">
            Dear users,
            <br><br>
            We would like to inform you that this online store is not a real commercial project, but rather a personal project to demonstrate web application development skills.
            <br><br>
            If you are interested in studying the source code of this project, you can find it on GitHub at the following link: <a href="https://github.com/Divrun/Store-Laravel-Vue" target="_blanc">https://github.com/Divrun/Store-Laravel-Vue</a>
            <br><br>
            Thank you for your understanding.
        </div>
        <div v-if="menu.ru">
            Уважаемые пользователи,
            <br><br>
            Хотели бы вас проинформировать, что данный интернет-магазин не является настоящим коммерческим проектом, а лишь личным проектом для демонстрации навыков разработки веб-приложений.
            <br><br>
            Если вы заинтересованы в изучении исходного кода этого проекта, вы можете найти его на GitHub по следующей ссылке: <a href="https://github.com/Divrun/Store-Laravel-Vue" target="_blanc">https://github.com/Divrun/Store-Laravel-Vue</a>
            <br><br>
            Спасибо за понимание.
        </div>
        <div v-if="menu.stack">
            Frontend: Vue.js 3, Pinia, Chart.js, VueRouter, Axios, UIkit
            <br><br>
            Backend: Laravel 10, Spatie, MySQL
        </div>
        <div v-if="menu.features" class="uk-margin-left">
            <ul>
                <li>RESTful API with roles. Admin panel with the ability to manage products, view statistics and a list of orders with filters.</li>
                <li>Displaying monthly statistics on orders and best-selling products using chart.js</li>
                <li>Viewing orders and products in the form of lists and tables</li>
                <li>Profile with the ability to view orders with filters</li>
                <li>SPA with using a Vue3, Vue Router, Axios, UIkit</li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AboutPage',

    data() {
        return {
            menu: {
                en: true,
                ru: false,
                stack: false,
                features: false
            }
        }
    },
    
    methods: {
        changeTab(name) {
            Object.keys(this.menu).map(key => {
                this.menu[key] = false
                if (key == name) this.menu[key] = true;
            });
        }
    }
}
</script>