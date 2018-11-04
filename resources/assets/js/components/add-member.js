Vue.component('add-member', {
    props: ['user', 'team'],


    data() {
        return {
            members: [],

            form: new SparkForm({
                name: '',
                phone: '',
				email: '',
                emergency_name: '',
                emergency_phone: '',
				password: '',
                emergency_carer: true,
            })
        };
    },
    computed: {
        actualPhone: function() {
            if (this.form.phone != '')
                return "61" + this.form.phone.replace(/\b0+/g, '').replace(/()-/g,'')
            else 
                return this.form.phone.replace(/()-/g,'')
        },
        actualEmergencyPhone: function() {
            if (this.form.emergency_phone != '')
                return "61" + this.form.emergency_phone.replace(/\b0+/g, '').replace(/()-/g,'')
            else 
                return this.form.emergency_phone.replace(/()-/g,'')
        }
    },

    created() {
        this.getMembers();
    },
    methods: {
        getMembers() {
            axios.get('/api/members')
                .then(response => {
                    this.members = response.data;
                });
        },


        createMember() {
            this.form.phone = this.actualPhone;
            this.form.emergency_phone = this.actualEmergencyPhone;
            Spark.post('/api/add-member', this.form)
                .then(member => {
                    this.members.push(member);
                    this.form.name = '';
                    this.form.phone = '';
                    this.form.email = '';
                    this.form.password = '';
                    this.form.emergency_name = '';
                    this.form.emergency_phone = '';
                    this.form.emergency_carer = '';
                    window.location = "/home";
                });
                
        },


        deleteMember(member) {
        	
            axios.delete('/api/delete-member/' + member.id);

            this.members = _.reject(this.members, t => t.id == member.id);
        }
    }
});
