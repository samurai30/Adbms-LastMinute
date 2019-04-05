
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

const use = require('@tensorflow-models/universal-sentence-encoder');

const  tf = require('@tensorflow/tfjs');
const cs = require('compute-cosine-similarity');

require('regenerator-runtime/runtime');

const sentences = [
   'Dbms is very important subject',
   'One of the important subject is Dbms',
    'explain c++'
];


$(document).ready(async function () {

   $('select').formSelect();
   $('.tabs').tabs();
   $('.tabs').tabs({
      duration: 800
   });


   const model = await use.load();
    const embeddings = await model.embed(sentences);


/*
   const sim = await tf.sum(tf.mul(emb1,emb2),1);
   const clip = await tf.clipByValue(sim,-1.0,1.0);
   const acos = await tf.acos(clip);
   const cosSim = (1.0 - acos);
   */



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
   }





});