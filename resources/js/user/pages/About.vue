<template>
    <Card>
        <ul uk-tab>
            <li v-for="(isActive, name) in menu"
                :key="name" 
                :class="{'uk-active': isActive}">
                <a href="#" @click="changeTab(name)">{{ name }}</a>
            </li>
        </ul>
        <keep-alive>
            <component :is="activeTab" />
        </keep-alive>
    </Card>
</template>

<script setup lang="ts">
import English from '../components/about/English.vue';
import Russian from '../components/about/Russian.vue';
import Stack from '../components/about/Stack.vue';
import Features from '../components/about/Features.vue';
import { computed, reactive } from 'vue';
import Card from '../../components/Card.vue';

type Menu = {
    en: boolean;
    ru: boolean;
    stack: boolean;
    features: boolean;
}

const menu = reactive<Menu>({
    en: true,
    ru: false,
    stack: false,
    features: false
});

const changeTab = (name: keyof Menu): void => {
    Object.keys(menu).map((key: keyof Menu) => {
        menu[key] = false;
        if (key == name) menu[key] = true;
    });
}

const activeTab = computed(() => {
    switch(true) {
        case menu.en:
            return English;
        case menu.ru:
            return Russian;
        case menu.stack:
            return Stack;
        case menu.features:
            return Features;
    }
})
</script>