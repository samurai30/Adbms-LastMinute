const $ = require('jquery');
global.$ = global.jQuery = $;
require('materialize-css/dist/js/materialize');
const Chart = require('chart.js');
const axios = require('axios');
/*
let ctx = $('#myChart');

let myChart = new Chart(ctx, {
   type: 'doughnut',
   data: {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
      datasets: [{
         label: '# of Votes',
         data: [12, 19, 3, 5, 2, 3],
         backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
         ],
         borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
         ],
         borderWidth: 1
      }]
   },
   options: {
   }
});
*/



require('regenerator-runtime/runtime');


export const use = require('@tensorflow-models/universal-sentence-encoder');
global.use = use;


$(document).ready(async function () {

   $('select').formSelect();
   $('.tabs').tabs();
   $('.tabs').tabs({
      duration: 800
   });
   $('.modal').modal();
   $('#Login').css({'zIndex':100});
   $('.chips').chips();

   $('#add_questions_Year').change(function () {
      let selectedYear = $(this).children("option:selected").val();
      $('.chips-placeholder').chips({
         data: [{
            tag: selectedYear,
         }],
         placeholder: 'Tags',
         secondaryPlaceholder: '+Tag',
      });
   });

   $('#add_questions').on('submit',function (e) {
      e.preventDefault();
      let tagsData = JSON.stringify(M.Chips.getInstance($('.chips')).chipsData) ;
     if(tagsData === "[]"){
         $('#errorTags').show()
     }
     else {
        $('#errorTags').hide();
         let formData = new FormData(e.target);
         formData.append('chipsData',tagsData);
        axios.post('/teacher/manual',formData).then((res)=>{
             if(res.data === 'success'){
                 $('#add_questions').trigger("reset");
                 let toastSuccess = '<span>Question Added Successfully.</span>';
                 let toastAddMore = '<span>Add More as you like.</span>';
                 M.toast({html: toastSuccess});
                 M.toast({html: toastAddMore});
             }else {
                 let toastError = '<span>Sorry Something went wrong!</span><button class="btn-flat toast-action">Undo</button>';
                 M.toast({html: toastError});

             }
        });
     }
   })



   /*const model = await use.load();
    const embeddings = await model.embed(sentences);

   for (let i = 0; i < sentences.length; i++) {
      for (let j = i; j < sentences.length; j++) {
         const sentenceI = embeddings.slice([i, 0], [1]);
         const sentenceJ = embeddings.slice([j, 0], [1]);
         const sentenceITranspose = false;
         const sentenceJTransepose = true;
         const score =
             sentenceI.matMul(sentenceJ, sentenceITranspose, sentenceJTransepose)
                 .dataSync();
         console.log(score);
         console.log(i+" "+j);

      }
   }   */

});


