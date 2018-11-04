Vue.component('mobile-appointment', {
    props: ['appointment'],
    data() {
        return {
            photos: '',
            checkin: '',
            slider: null,
            form: new SparkForm({
                photo: '', 

            })
        };
    },
    mounted() {
        // console.log(this.appointment);
        this.getPhotos();
    },

    methods: {
      
        getPhotos() {
            axios.get('/api/photos/' + this.appointment.id)
                .then(response => {
                    this.photos = response.data;
                });
            
        },

        checkIn() {
            axios.post('/api/checkin/' + this.appointment.id)
                .then(response => {
                    this.checkin = response.data;
                });
        },

        createPhoto(e) {
           var file = e.target.files[0];
           if (file) {
                if (/^image\//i.test(file.type)) {
                    this.readFile(file);
                } else {
                    alert('Not a valid image!');
                }
            }
        },
        readFile(file) {
            var reader = new FileReader();

            reader.onloadend = ()=> {

                this.processFile(reader.result, file.type);
            }

            reader.onerror = function () {
                alert('There was an error reading the file!');
            }

            reader.readAsDataURL(file);
        },

        processFile(dataURL, fileType) {
            var preimage = new Image();
            preimage.src = dataURL;
            var self = this;
            preimage.onload =  function () {
                var precanvas = document.createElement('canvas');

                precanvas.width = preimage.width;
                precanvas.height = preimage.height;

                var precontext = precanvas.getContext('2d');

                function base64ToArrayBuffer (base64) {
                    base64 = base64.replace(/^data\:([^\;]+)\;base64,/gmi, '');
                    var binaryString = atob(base64);
                    var len = binaryString.length;
                    var bytes = new Uint8Array(len);
                    for (var i = 0; i < len; i++) {
                        bytes[i] = binaryString.charCodeAt(i);
                    }
                    return bytes.buffer;
                }
                var exif = EXIF.readFromBinaryFile(base64ToArrayBuffer(dataURL));
                switch(exif.Orientation){
                    case 6:
                        // 90° rotate right
                        precanvas.setAttribute('width', preimage.height);
                        precanvas.setAttribute('height', preimage.width);
                        precontext.rotate(0.5 * Math.PI);
                        precontext.drawImage(this, 0, -preimage.height);
                        //precontext.rotate(0.5 * Math.PI);
                        //precontext.translate(0, -precanvas.height);
                        break;
                    default:
                        precanvas.setAttribute('width', preimage.width);
                        precanvas.setAttribute('height', preimage.height);
                        precontext.drawImage(preimage, 0, 0);
                }

                //precontext.drawImage(this, 0, 0, preimage.width, preimage.height);
                dataURL = precanvas.toDataURL(fileType);

                self.lastprocessFile(dataURL, fileType);
                //self.sendFile(dataURL);
            };
        },

        lastprocessFile(dataURL, fileType) {
            var maxWidth = 800;
            var maxHeight = 800;
            var ratio = 0;  // Used for aspect ratio
            var image = new Image();
            image.src = dataURL;
            var self = this;
            image.onload =  function () {
                var width = image.width;
                var height = image.height;
               
                var shouldResize = (width > maxWidth) || (height > maxHeight);

                if (!shouldResize) {
                    self.sendFile(dataURL);
                    return;
                }
                var result = self.ScaleImage(width, height, 800, 800, true);

                console.log(result.width);
                console.log(result.height);
                
                var canvas = document.createElement('canvas');

                canvas.width = result.width;
                canvas.height = result.height;

                var context = canvas.getContext('2d');

                context.drawImage(this, 0, 0, result.width, result.height);

                dataURL = canvas.toDataURL(fileType);

                self.sendFile(dataURL);
            };

            image.onerror = function () {
                alert('There was an error processing your file!');
            };
        },

        sendFile(fileData) {

            var formData = new FormData();

            formData.append('photo', fileData);

            var self = this;
            this.form.startProcessing();
            axios.post('/api/photo/' + this.appointment.id, formData)
            .then(
                photo => {
                    self.form.finishProcessing();
                    this.photos.push(photo.data);
                })
            .catch(error => {
                    // error callback
                    self.form.setErrors(error.response.data);
            });
        },
        ScaleImage(srcwidth, srcheight, targetwidth, targetheight, fLetterBox) {

            var result = { width: 0, height: 0, fScaleToTargetWidth: true };

            if ((srcwidth <= 0) || (srcheight <= 0) || (targetwidth <= 0) || (targetheight <= 0)) {
                return result;
            }

            // scale to the target width
            var scaleX1 = targetwidth;
            var scaleY1 = (srcheight * targetwidth) / srcwidth;

            // scale to the target height
            var scaleX2 = (srcwidth * targetheight) / srcheight;
            var scaleY2 = targetheight;

            // now figure out which one we should use
            var fScaleOnWidth = (scaleX2 > targetwidth);
            if (fScaleOnWidth) {
                fScaleOnWidth = fLetterBox;
            }
            else {
               fScaleOnWidth = !fLetterBox;
            }

            if (fScaleOnWidth) {
                result.width = Math.floor(scaleX1);
                result.height = Math.floor(scaleY1);
                result.fScaleToTargetWidth = true;
            }
            else {
                result.width = Math.floor(scaleX2);
                result.height = Math.floor(scaleY2);
                result.fScaleToTargetWidth = false;
            }
            result.targetleft = Math.floor((targetwidth - result.width) / 2);
            result.targettop = Math.floor((targetheight - result.height) / 2);

            return result;
        },
        
    }
});
