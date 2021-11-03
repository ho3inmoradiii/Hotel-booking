<template>
    <div v-if="loading">
        Data is loading...
    </div>
    <div class="container" v-else>
        <div class="row">

            <div class="col-md-4 mb-sm-4">
                <h5 class="pl-3" style="direction: ltr;font-size: 17px;">What are you looking for?</h5>
                <div class="d-flex flex-column">
                    <div v-for="idx in type" :key="idx" class="pl-3">
                        <input type="radio" :id="idx" :value="idx" v-model="search">
                        <label :for="idx" class="labelFilter">{{ idx }} ({{numberOfBookable(idx)}})</label>
                    </div>
                </div>
                <div class="slidecontainer mt-4">
<!--                    <input type="range" id="volume" name="volume"-->
<!--                           min="0" max="11">-->
                    <div class="d-flex justify-content-between">
                        <h5 class="pl-3 mb-3" style="direction: ltr;font-size: 17px;">What price are you looking for?</h5>
                        <h6 v-if="slider">{{ slider }} $</h6>
                    </div>
                    <input type="range"
                           style="direction: ltr"
                           id="cowbell"
                           min="20"
                           max="600"
                           value="600"
                           step="20"
                           class="slider"
                           v-model="slider"
                    >
                </div>
            </div>
            <div class="col-12 col-md-8 bookables">
                <div class="row">
                    <bookable-list-item
                        v-for="(bookable,index) in filterPrice"
                        :key="index"
                        :title="bookable.title"
                        :description="bookable.description"
                        :id="bookable.id"
                        :price="bookable.price"
                        v-bind:price="bookable.price"
                        class="col-md-6 col-sm-6"
                    ></bookable-list-item>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import BookableListItem from './BookableListItem';
    export default {
        components:{BookableListItem},
        data(){
            return{
                loading:false,
                bookables: null,
                type:[
                    'Villa',
                    'House',
                    'Cottage',
                    'Luxury villas',
                    'Rooms'
                ],
                search:null,
                slider:null
            }
        },
        async created() {
            try {
                this.loading = true
                let response = await axios.get('/api/bookables')
                this.bookables = response.data.data
                this.loading = false
                // axios.get('/api/bookables')
                //     .then(res => {
                //         this.bookables = res.data.data
                //         this.loading = false
                //     })
                this.$store.dispatch("loadUser");
            }catch (e) {
                console.log(e.response.data)
            }

        },
        computed:{
            filterBooking(){
                if (this.search){
                    return this.bookables.filter((bookable) => {
                        return bookable.title.match(this.search);
                    })
                }
                return this.bookables;
            },
            filterPrice(){
                if (this.slider){
                    return this.filterBooking.filter((bookable) => {
                        return bookable.price <= this.slider;
                    })
                }
                return this.filterBooking;
            }
        },
        methods:{
            numberOfBookable(idx){
                const bookables = this.filterPrice.filter((bookable) => {
                    return bookable.title.match(idx);
                });
                return bookables.length;
            }
        },
        beforeMount() {
            if (this.bookables){
                this.numberOfBookable();
            }
        }
    }
</script>

<style scoped>
    .dir-rtl{
        direction: rtl;
    }

    .slidecontainer {
        width: 100%; /* Width of the outside container */
    }

    /* The slider itself */
    .slider {
        -webkit-appearance: none;  /* Override default CSS styles */
        appearance: none;
        width: 90%; /* Full-width */
        height: 25px; /* Specified height */
        background: #d3d3d3; /* Grey background */
        outline: none; /* Remove outline */
        opacity: 0.7; /* Set transparency (for mouse-over effects on hover) */
        -webkit-transition: .2s; /* 0.2 seconds transition on hover */
        transition: opacity .2s;
        margin-left: 16px;
    }

    /* Mouse-over effects */
    .slider:hover {
        opacity: 1; /* Fully shown on mouse-over */
    }

    /* The slider handle (use -webkit- (Chrome, Opera, Safari, Edge) and -moz- (Firefox) to override default look) */
    .slider::-webkit-slider-thumb {
        -webkit-appearance: none; /* Override default look */
        appearance: none;
        width: 25px; /* Set a specific slider handle width */
        height: 25px; /* Slider handle height */
        background: yellow; /* yellow background */
        cursor: pointer; /* Cursor on hover */
        z-index: 999;
    }

    .slider::-moz-range-thumb {
        width: 25px; /* Set a specific slider handle width */
        height: 25px; /* Slider handle height */
        background: yellow; /* yellow background */
        cursor: pointer; /* Cursor on hover */
        z-index: 999;
    }

    @media screen and (max-width: 768px) {
        .bookables {
            margin-top: 40px;
        }
    }
</style>
