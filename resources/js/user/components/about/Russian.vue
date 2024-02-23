<template>
    Уважаемые пользователи,
    <br><br>
    Хотели бы вас проинформировать, что данный интернет-магазин не является настоящим коммерческим проектом, а лишь личным проектом для демонстрации навыков разработки веб-приложений.
    <br><br>
    Если вы заинтересованы в изучении исходного кода этого проекта, вы можете найти его на GitHub по следующей ссылке: <a :href="GITHUB_REPOSITORY" target="_blanc">{{ GITHUB_REPOSITORY }}</a>
    <br><br>
    Спасибо за понимание.
</template>

<script setup lang="ts">
import { GITHUB_REPOSITORY } from '@helpers/constants';
</script>