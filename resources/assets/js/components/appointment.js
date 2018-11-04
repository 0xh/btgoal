Vue.component('appointment', {
    props: ['user'],
    data() {
        return {
            repeat_options: [{value:'none', label: 'None'}, {value:'daily', label: 'Daily'},
            {value:'weekly', label: 'Weekly'},{value:'monthly', label: 'Monthly'}, {value:'yearly', label: 'Yearly'},],
            appointments: [],
            appointment: null,
            category: null,
            categories: [],
            contact:null,
            contacts: [],
            organisation: null,
            organisations: [],
            start_date: null,
            start_time: null,
            loading: false,
            form: new SparkForm({
                // Appointment
                category_id: '', contact_id: '', organisation_id: '', photo: '', photo_name:'', send_sms: '1',
                title: '', start_date: '', start_time: '',  end_date: '', end_time: '',
                address: '', attendees: '', all_day: '', repeat_appointment: 'none',
                re_occurance_end_date: '',
                // Get ready
                get_ready_contact_id: '', get_ready_organisation_id: '',  get_ready_send_sms: '1',
                get_ready_title: '', get_ready_start_date: '', get_ready_start_time: '',  get_ready_end_date: '', get_ready_end_time: '',
                get_ready_address: '', get_ready_attendees: '', get_ready_all_day: '', 
                // Getting there
                getting_there_contact_id: '', getting_there_organisation_id: '',  getting_there_send_sms: '1',
                getting_there_title: '', getting_there_start_date: '', getting_there_start_time: '',  getting_there_end_date: '', getting_there_end_time: '',
                getting_there_address: '', getting_there_attendees: '', getting_there_all_day: '', 
                // After Appointment
                after_appointment_contact_id: '', after_appointment_organisation_id: '',  after_appointment_send_sms: '1',
                after_appointment_title: '', after_appointment_start_date: '', after_appointment_start_time: '',  after_appointment_end_date: '', after_appointment_end_time: '',
                after_appointment_address: '', after_appointment_attendees: '', after_appointment_all_day: ''
            })
        };
    },

    created() {
        this.getContacts();
    },
    computed: {
        repeat() {
            if (this.form.repeat_appointment === "none") return false;
            return true; 
        }
    },

    methods: {
        upload_image(e) {
            
            var files = e.target.files;
            var fileName = files[0].name;
            this.form.photo_name = fileName;
            // console.log(fileName);
        },
        /**
         * Gather the form data for the photo upload.
         */
        gatherFormData() {
            let form = document.querySelector('form');

            const data = new FormData(form);
            // Appointment
            if (this.$refs.photo.files[0] !== undefined) {
                data.append('photo', this.$refs.photo.files[0]); 
            }

            data.append('start_date', this.combineDateandTime(this.form.start_date, this.form.start_time));
            if (this.form.end_date) {
                data.append('end_date', this.combineDateandTime(this.form.end_date, this.form.end_time));
            }
            data.append('category_id', this.form.category_id);
            data.append('contact_id', this.form.contact_id);
            data.append('organisation_id', this.form.organisation_id);
            data.append('repeat_appointment', this.form.repeat_appointment);
            data.append('re_occurance_end_date', this.combineDateandTime(this.form.re_occurance_end_date, '23:59:59'));
            //Get Ready 
            if (this.form.get_ready_start_time) {
                data.append('get_ready_start_date', this.combineDateandTime(this.form.start_date, this.form.get_ready_start_time));
            }
            if (this.form.get_ready_end_time) {
                data.append('get_ready_end_date', this.combineDateandTime(this.form.end_date, this.form.get_ready_end_time));
            }
            data.append('get_ready_contact_id', this.form.get_ready_contact_id);
            data.append('get_ready_organisation_id', this.form.get_ready_organisation_id);
            //Getting There
            if (this.form.getting_there_start_time) {
                data.append('getting_there_start_date', this.combineDateandTime(this.form.start_date, this.form.getting_there_start_time));
            }
            if (this.form.getting_there_end_time) {
                data.append('getting_there_end_date', this.combineDateandTime(this.form.end_date, this.form.getting_there_end_time));
            }
            data.append('getting_there_contact_id', this.form.getting_there_contact_id);
            data.append('getting_there_organisation_id', this.form.getting_there_organisation_id);
            //After Appointment
            if (this.form.after_appointment_start_time) {
                data.append('after_appointment_start_date', this.combineDateandTime(this.form.start_date, this.form.after_appointment_start_time));
            }
            if (this.form.after_appointment_end_time) {
                data.append('after_appointment_end_date', this.combineDateandTime(this.form.end_date, this.form.after_appointment_end_time));
            }
            data.append('after_appointment_contact_id', this.form.after_appointment_contact_id);
            data.append('after_appointment_organisation_id', this.form.after_appointment_organisation_id);

            return data;
        },
      
        getContacts() {
            axios.get('/api/categories')
                .then(response => {
                    this.categories = response.data;
                });
            axios.get('/api/contacts')
                .then(response => {
                    this.contacts = response.data;
                });
            axios.get('/api/organisations')
                .then(response => {
                    this.organisations = response.data;
                });
        },

        createAppointment() {
            // Spark.post('/api/appointment', this.form);
            var self = this;
            this.form.startProcessing();
            axios.post('/api/appointment', this.gatherFormData())
            .then(
                () => {
                    self.form.finishProcessing();
                    this.clearAppointments();
                })
            .catch(error => {
                    // error callback
                    self.form.setErrors(error.response.data);
            });
        },

        remoteCategoryMethod(query) {
            query = query.toString();
        if (query !== '' ) {
            this.loading = true;
            setTimeout(() => {
                this.loading = false;
                this.category = this.categories.filter(item => {
                  return item.name.toLowerCase()
                    .indexOf(query.toLowerCase()) > -1;
                });
              }, 200);
            } else {
              this.category = [];
            }
        },

        remoteContactMethod(query) {
        if (query !== '') {
            query = query.toString();
            this.loading = true;
            setTimeout(() => {
                this.loading = false;
                this.contact = this.contacts.filter(item => {
                  return item.name.toLowerCase()
                    .indexOf(query.toLowerCase()) > -1;
                });
              }, 200);
            } else {
              this.category = [];
            }
        },

        remoteOrganisationMethod(query) {
            query = query.toString();
        if (query !== '') {
            this.loading = true;
            setTimeout(() => {
                this.loading = false;
                this.organisation = this.organisations.filter(item => {
                  return item.name.toLowerCase()
                    .indexOf(query.toLowerCase()) > -1;
                });
              }, 200);
            } else {
              this.category = [];
            }
        },

        combineDateandTime(form_date, form_time) {
            if (form_date !== "" ) {
                var d = new Date(form_date);
                let day = d.getDate();
                let year = d.getFullYear();
                let month = d.getMonth() + 1;
                return year + '-' + month + '-' + day + ' ' + form_time;
            }

            return "";
        },

        clearAppointments() {
            this.form.title = '';
            this.form.category_id = '';
            this.form.contact_id = '';
            this.form.organisation_id = '';
            this.form.title = '';
            this.form.start_date = '';
            this.form.star_ttime = '';
            this.form.end_date = '';
            this.form.end_time = '';
            this.form.address = '';
            this.form.attendees = '';
            this.form.all_day = '';
            this.form.send_sms = '1';
            this.form.repeat_appointment = 'none';

            this.form.get_ready_contact_id = '';
            this.form.get_ready_organisation_id = '';
            this.form.get_ready_send_sms =  '1';
            this.form.get_ready_title = '';
            this.form.get_ready_start_date = '';
            this.form.get_ready_start_time = '';
            this.form.get_ready_end_date = '';
            this.form.get_ready_end_time = '';
            this.form.get_ready_address = '';
            this.form.get_ready_attendees = '';
            this.form.get_ready_all_day = '';

            this.form.getting_there_contact_id = '';
            this.form.getting_there_organisation_id = '';
            this.form.getting_there_send_sms =  '1';
            this.form.getting_there_title = '';
            this.form.getting_there_start_date = '';
            this.form.getting_there_start_time = '';
            this.form.getting_there_end_date = '';
            this.form.getting_there_end_time = '';
            this.form.getting_there_address = '';
            this.form.getting_there_attendees = '';
            this.form.getting_there_all_day = '';

            this.form.after_appointment_contact_id = '';
            this.form.after_appointment_organisation_id = '';
            this.form.after_appointment_send_sms =  '1';
            this.form.after_appointment_title = '';
            this.form.after_appointment_start_date = '';
            this.form.after_appointment_start_time = '';
            this.form.after_appointment_end_date = '';
            this.form.after_appointment_end_time = '';
            this.form.after_appointment_address = '';
            this.form.after_appointment_attendees = '';
            this.form.after_appointment_all_day = '';
        }
        
    }
});
