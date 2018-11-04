var base = require('settings/teams/create-team');

Vue.component('spark-create-team', {
    mixins: [base], 
    data() {
        return {
            oneTeam: false,
        };
    },
    computed: {
    	canCreateTeam() {
    		if (Spark.state.currentTeam || this.oneTeam) {
    			return false
    		} else {
    			return true
    		}
    	}
    },
    methods: {
    	/**
         * Create a new team.
         */
        create() {
            Spark.post('/settings/'+Spark.pluralTeamString, this.form)
                .then(() => {
                    this.form.name = '';
                    this.form.slug = '';
                    this.oneTeam = true;
                    Bus.$emit('updateUser');
                    Bus.$emit('updateTeams');
                });
        }
    }
});
