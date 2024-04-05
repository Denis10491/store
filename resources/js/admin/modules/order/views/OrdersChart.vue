<script setup lang="ts">
import {Bar} from "vue-chartjs";
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
        <p>Orders per month</p>
        <Bar
            :options="options"
            :data="data"
        />
    </div>
</template>
