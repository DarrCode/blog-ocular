<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <v-card>
                    <v-card-text >
                        <v-card-title>¡ Estadísticas !</v-card-title>
                        <highcharts :options="chartOptions"></highcharts>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            comments: [],
            options: ['spline', 'line', 'bar', 'pie', 'column'],
            posts: []
        }
    },
    methods: {
        async visits() {
            try {
                const url    = `/admin/all/visits`
                let response = await axios.get(url)

                if (response.data)
                    this.posts = response.data
                
            } catch (err) {
                console.log(err)
            }
        }
    },
    computed: {
        chartOptions() { 
            return {
                chart: { 
                    type: 'pie' 
                },
                title: { 
                    text: `Total de post: ${ this.posts.length }` 
                },
                series: [{
                    name: 'Vistas',
                    colorByPoint: true,
                    data: this.posts
                }]
            }
        },
    },
    mounted() {
        this.visits()
    }
}
</script>