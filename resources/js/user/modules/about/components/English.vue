<template>
    Dear users,
    <br><br>
    We would like to inform you that this online store is not a real commercial project, but rather a personal project to demonstrate web application development skills.
    <br><br>
    If you are interested in studying the source code of this project, you can find it on GitHub at the following link: <a :href="GITHUB_REPOSITORY" target="_blanc">{{ GITHUB_REPOSITORY }}</a>
    <br><br>
    Thank you for your understanding.
</template>

<script setup lang="ts">
import { GITHUB_REPOSITORY } from '@helpers/constants';
</script>