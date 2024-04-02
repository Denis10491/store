<script setup lang="ts">
import {computed, ref} from 'vue';

const props = defineProps<{
    currentPage: number,
    numOfMaxPage: number
}>()
const emit = defineEmits<{
    (e: 'changePage', num: number): Promise<void>,
}>()

const maxInRange = ref<number>(5)

const handleChangePage = (num: number) => emit('changePage', num);

const range = computed<Array<number>>(() => {
    let range = [];
    if (props.currentPage === 1) {
        for (let i = 2; i < maxInRange.value; i++) {
            range.push(i);
        }
        return range;
    }
    if (props.currentPage === props.numOfMaxPage) {
        for (let i = props.numOfMaxPage + 1 - maxInRange.value; i < props.numOfMaxPage - 1; i++) {
            range.push(i);
        }
        return range;
    }
    for (let i = props.currentPage - 2; i < props.currentPage; i++) {
        if (i <= 1 || i == props.numOfMaxPage) continue;
        range.push(i)
    }
    for (let i = props.currentPage; i < props.currentPage + 3; i++) {
        if (i >= props.numOfMaxPage) break;
        range.push(i)
    }
    return range;
});
</script>

<template>
    <ul class="uk-pagination uk-flex-center" uk-margin>
        <li @click="handleChangePage(currentPage - 1)"><a href="#"><span uk-pagination-previous></span></a></li>
        <li
            :class="{
            'uk-active': currentPage == 1
        }"
            @click="handleChangePage(1)"
        >
            <a href="#">1</a>
        </li>
        <li class="uk-disabled" v-if="range[0] > 2"><span>…</span></li>
        <li v-for="page in range"
            :key="page"
            :class="{
            'uk-active': currentPage == page
        }"
            @click="handleChangePage(page)"
        >
            <a href="#">{{ page }}</a>
        </li>
        <li class="uk-disabled" v-if="range[range.length - 1] < numOfMaxPage - 1"><span>...</span></li>
        <li
            :class="{
            'uk-active': currentPage == numOfMaxPage
        }"
            @click="handleChangePage(numOfMaxPage)"
        >
            <a href="#">{{ numOfMaxPage }}</a>
        </li>
        <li @click="handleChangePage(currentPage + 1)"><a href="#"><span uk-pagination-next></span></a></li>
    </ul>
</template>
