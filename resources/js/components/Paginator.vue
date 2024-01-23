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
    <li class="uk-disabled" v-if="range[range.length - 1] < this.numOfMaxPage - 1"><span>...</span></li>

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

<script>
export default {
    name: 'PaginatorComponent',
    props: [ 'currentPage', 'changePage', 'numOfMaxPage' ],

    data() {
        return {
            maxInRange: 5
        }
    },

    computed: {
        range() {
            let range = [];
            if (this.currentPage == 1) {
                for(let i = 2; i < this.maxInRange; i++) {
                    range.push(i);
                }
                return range;
            }

            if (this.currentPage == this.numOfMaxPage) {
                for(let i = this.numOfMaxPage + 1 - this.maxInRange; i < this.numOfMaxPage - 1; i++) {
                    range.push(i);
                }
                return range;
            }

            for(let i = this.currentPage - 2; i < this.currentPage; i++) {
                if (i <= 1 || i == this.numOfMaxPage) continue;
                range.push(i)
            }
            for(let i = this.currentPage; i < this.currentPage + 3; i++) {
                if (i >= this.numOfMaxPage) break;
                range.push(i)
            }

            return range;
        }
    },

    methods: {
        handleChangePage(num) {
            this.changePage(num);
        }
    }
}
</script>