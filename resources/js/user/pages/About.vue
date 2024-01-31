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

        <keep-alive>
            <component :is="activeTab" />
        </keep-alive>
    </div>
</template>

<script>
import English from '../components/about/English.vue';
import Russian from '../components/about/Russian.vue';
import Stack from '../components/about/Stack.vue';
import Features from '../components/about/Features.vue';

export default {
    name: 'AboutPage',
    components: { English, Russian, Stack, Features },

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
    },

    computed: {
        activeTab() {
            switch(true) {
                case this.menu.en:
                    return English;
                case this.menu.ru:
                    return Russian;
                case this.menu.stack:
                    return Stack;
                case this.menu.features:
                    return Features;
            }
        }
    }
}
</script>