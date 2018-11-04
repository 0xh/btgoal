Vue.component('mobile-task', {
    props: ['task'],
    data() {
        return {
            checkin: '',
            form: new SparkForm({
            })
        };
    },

    methods: {
        checkIn() {
            axios.post('/api/taskcheckin/' + this.task.id)
                .then(response => {
                    this.checkin = response.data;
                });
        },
        
    }
});
