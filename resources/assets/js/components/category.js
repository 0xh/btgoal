Vue.component('category', {
    props: ['user'],


    data() {
        return {
            categories: [],
            category: null,
            create: true,
            form: new SparkForm({
                name: ''
            })
        };
    },


    created() {
        this.getCategories();
    },


    methods: {
        showModal() {
            this.create = true;
            this.form.name = '';
            $('#modal-update-category').modal('show');
        },

        getCategories() {
            axios.get('/api/categories')
                .then(response => {
                    this.categories = response.data;
                });
        },

        updateCategory() {
            Spark.put('/api/category/' + this.category.id, this.form)
            .then ( category => {
                let num = this.categories.findIndex( t => t.id == category.id);
                this.$set(this.categories, num, category);
                this.form.name = '';
                $('#modal-update-category').modal('hide');
                this.create = true;
            });
            
        },

        createCategory() {
            Spark.post('/api/category', this.form)
                .then(category => {
                    this.categories.push(category);
                    this.form.name = '';
                });
        },

        editCategory(category) {
            this.form.resetStatus();
            this.form.name = category.name;
            this.category = category;
            this.create = false;
            $('#modal-update-category').modal('show');
        },

        deleteCategory(category) {
            axios.delete('/api/category/' + category.id);
            this.categories = _.reject(this.categories, t => t.id == category.id);
        }
    }
});
