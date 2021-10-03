<template>
    <section>
        <div v-if="!bookable">
            Data is loading...
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card" v-if="bookable">
                    <div class="card-body">
                        <h5 class="card-title">{{ bookable.title }}</h5>
                        <hr />
                        <p class="card-text">{{ bookable.description }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                Availability & price
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        data(){
            return{
                bookable:null,
            }
        },
        props:['id'],
        created() {
            axios.get(`/api/bookables/${this.id}`)
            .then(res => {
                this.bookable = res.data
            })
        }
    }
</script>
