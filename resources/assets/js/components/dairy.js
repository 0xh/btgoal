Vue.component('dairy', {
    props: ['user', 'appointment'],


    data() {
        return {
            notes: [],
            note: null,
            write_note: false,
            form: new SparkForm({
                description: ''
            })
        };
    },


    created() {
        // this.getNotes();
    },


    methods: {

        getNotes() {
            axios.get('/api/notes/')
                .then(response => {
                    this.notes = response.data;
                });
        },

        

        createNote() {
            Spark.post('/api/note', this.form)
                .then(note => {
                    this.notes.push(note);
                    this.form.description = '';
                });
        },

    }
});
