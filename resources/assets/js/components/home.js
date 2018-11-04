Vue.component('home', {
    props: ['user'],
    data() {
      return {
	      eventSources: [
	        {
	          events(start, end, timezone, callback) {
	            axios.get('/api/appointments/'+start+'/'+end)
                .then(response => {
                    callback(response.data)
                });
	          },
	          color: '#3B91AD',
	          textColor: 'white',
	        },
             {
              events(start, end, timezone, callback) {
                axios.get('/api/tasks/'+start+'/'+end)
                .then(response => {
                    callback(response.data)
                });
              },
              color: '#00BCA4',
              textColor: 'white',
            },
	      ]
	    }
    },
    methods: {
    	getEvent(event) {
            // console.log(event.appointment_id);
            if (event.appointment_id === undefined ) {
              window.location.href = "/appointment/" + event.id;
            } else {
              window.location.href = "/task/" + event.id;
            }
            // 
    	},
      dropEvent(event) {
            if (event.appointment_id === undefined ) {
              var sdate = event.start.format("YYYY-MM-DD") + " " + event.start.format("HH:mm:ss");
              var edate = event.end.format("YYYY-MM-DD") + " " + event.end.format("HH:mm:ss");
              if (event.allday) {
                var allday = 1;
              } else {
                var allday;
              }
              var id = event.id;
              axios.post('/api/appointment/update', {
                sdate: sdate,
                edate: edate,
                allday: allday,
                id: id
              });
            } else {
              var sdate = event.start.format("YYYY-MM-DD") + " " + event.start.format("HH:mm:ss");
              var edate = event.end.format("YYYY-MM-DD") + " " + event.end.format("HH:mm:ss");
              if (event.allday) {
                var allday = 1;
              } else {
                var allday;
              }
              var id = event.id;
              axios.post('/api/task/update', {
                sdate: sdate,
                edate: edate,
                id: id
              });
            }
      },
      resizeEvent(event) {
            if (event.appointment_id === undefined ) {
              var sdate = event.start.format("YYYY-MM-DD") + " " + event.start.format("HH:mm:ss");
              var edate = event.end.format("YYYY-MM-DD") + " " + event.end.format("HH:mm:ss");
              var id = event.id;
              axios.post('/api/appointment/update', {
                sdate: sdate,
                edate: edate,
                id: id
              });
            } else {
              var sdate = event.start.format("YYYY-MM-DD") + " " + event.start.format("HH:mm:ss");
              var edate = event.end.format("YYYY-MM-DD") + " " + event.end.format("HH:mm:ss");
              var id = event.id;
              axios.post('/api/task/update', {
                sdate: sdate,
                edate: edate,
                id: id
              });
            }
      },
      createEvent(event) {
        var sdate = event.start.format("DD-MM-YYYY");
        var stime = event.start.format("h:mma");
        var edate = event.end.format("DD-MM-YYYY");
        var etime = event.end.format("h:mma");
        window.location.href = '/appointment/?sdate='+sdate+'&stime='+stime+'&edate='+edate+'&etime='+etime;
      }
    },
    mounted() {
        const myway = this;
    }
});
