function greatComplete(data) {

    $.gritter.add({
         title: 'Information !',
         text: data.message,
         sticky: false,
         time: '3500',
         class_name: data.gritter
    })

}