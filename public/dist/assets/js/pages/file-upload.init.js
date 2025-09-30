
const handleChange = function() {
  const fileUploader = document.querySelector('#input-file');
      const getFile = fileUploader.files
      if (getFile.length !== 0) {
          const uploadedFile = getFile[0];
          readFile(uploadedFile);
      }
  }
  const readFile = function (uploadedFile) {
      if (uploadedFile) {
          const reader = new FileReader();
          reader.onload = function () {
          const parent = document.querySelector('.preview-box');
          parent.innerHTML = `<img class="preview-content" src=${reader.result} />`;
          };
          
          reader.readAsDataURL(uploadedFile);
      }
  };

  // var uppy = new Uppy.Uppy()
  //       .use(Uppy.Dashboard, {
  //         inline: true,
  //         target: '#drag-drop-area'
  //       })
  //       .use(Uppy.Tus, {endpoint: 'https://tusd.tusdemo.net/files/'})

  //     uppy.on('complete', (result) => {
  //     })

  var uppy = new Uppy.Uppy({
    restrictions: {
        maxNumberOfFiles: 1,
        maxFileSize: 5 * 1024 * 1024, // 5MB
        allowedFileTypes: ['.pdf', '.doc', '.docx', '.jpg', '.jpeg', '.png'],
    },
    autoProceed: true,
    })
    .use(Uppy.Dashboard, {
        inline: true,
        target: '#drag-drop-area',
        showProgressDetails: true,
        proudlyDisplayPoweredByUppy: false,
    })
    .use(Uppy.XHRUpload, {
        endpoint: '/upload', //
        method: 'POST',
        formData: true,
        fieldName: 'file',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    });

    // Kalau upload sukses, ambil file path dari response server
    uppy.on('upload-success', (file, response) => {
        console.log('Upload berhasil:', response);

        // Ambil file path dari server (asumsi server kirim { file_path: 'uploads/surat_masuk/xxx.pdf' })
        if (response.body && response.body.file_path) {
            document.getElementById('uploaded_file_path').value = response.body.file_path;
        }
    });

    // Kalau hapus file
    uppy.on('file-removed', () => {
        document.getElementById('uploaded_file_path').value = '';
    });

