<script setup lang="ts">
import {Pie} from "vue-chartjs";
import {
    ArcElement,
    BarElement,
    CategoryScale,
    Chart as ChartJS,
    Colors,
    Legend,
    LinearScale,
    Title,
    Tooltip
} from "chart.js";

defineProps<{
    options: object,
    data: object
}>()

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement, Colors)
</script>

<template>
    <div class="uk-width-1-2">
        <p>Best selling products per month</p>
        <Pie
            :options="options"
            :data="data"
        />
    </div>
</template>
