lengthMenu : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
statesave:true,
processing: true,
serverSide: true,
dom: 'Bfrtip',
buttons: {
dom: {
button: {
tag: 'button',
className: 'btn btn-primary'
}
},
buttons: [
{
extend: 'excel',
titleAttr: 'Excel',
text: 'Excel',
}, {
extend: 'copy',
titleAttr: 'Copiar',
text: 'Copiar'
},
, {
extend: 'pdf',
titleAttr: 'Pdf',
text: 'Pdf'
}
]
}