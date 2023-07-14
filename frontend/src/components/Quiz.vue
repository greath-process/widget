<template>
  <div class="container">

    <ul class="nav nav-tabs">
      <li class="nav-item" v-for="(step, key) in filteredSteps" v-bind:key="step.id">
        <a
            class="nav-link"
            :class="step.active ? 'active' : ''"
            aria-current="page"
            @click="getToStep(step.id)"
        >
          {{ stepText }} {{ (key + 1) }}
        </a>
      </li>
    </ul>

    <div v-if="startStep">
      <div class="order-md-1 d-block">
        <img width="110" height="50" :src="frontendHost + logoImage" class="mt-4 mb-2" alt="">
        <h4 class="mb-3 mt-4 w-100 text" v-text="startStepText"></h4>
        <div class="row blocks-wrapper block-with-icons">
          <label
              class="col-md-4 card mb-2 mr-2 ml-auto box-shadow clickable"
              style="border-radius: 30px;"
              @click="setStartSteps(stepTypeConfigurator)"
          >
            <div class="input-block" style="margin-top: auto; margin-bottom: auto; min-height: 30px;">
              <div class="block-item-wrapper pt-3 pb-3 mb-0">
                <span class="block-item">
                  <span class="block-item__title text" v-text="startConfigButton"></span>
                </span>
              </div>
            </div>
          </label>
          <label
              class="col-md-4 card mb-2 mr-auto ml-2 box-shadow clickable"
              style="border-radius: 30px;"
              @click="setStartSteps(stepTypeModel)"
          >
            <div class="input-block" style="margin-top: auto; margin-bottom: auto; min-height: 30px;">
              <div class="block-item-wrapper pt-3 pb-3 mb-0">
                <span class="block-item">
                  <span class="block-item__title text" v-text="startModelButton"></span>
                </span>
              </div>
            </div>
          </label>
        </div>
      </div>
    </div>

    <div v-if="!startStep">
      <form class="row" v-if="!thanks && !recommendationStep">
        <div
            class="col-md-12 order-md-1"
            v-for="step in filteredSteps"
            v-bind:key="step.id"
            :class="step.active ? 'd-block' : 'd-none'"
        >
          <img width="110" height="50" :src="frontendHost + logoImage" class="mt-4" alt="">
          <h2 v-if="step.title" v-text="step.title" class="mt-4 mb-3 text"></h2>
          <h6 v-if="step.subtitle" v-text="step.subtitle" class="mb-5"></h6>

          <div v-if="step.type">
            <div v-if="step.type" class="form-row">
              <div class="form-group text-justify col-md-6">
                <label :for="steps[questionStepKey].questions[0].title" v-text="steps[questionStepKey].questions[0].title"></label>
                <input :type="steps[questionStepKey].questions[0].type ?? 'text'" v-model="steps[questionStepKey].questions[0].answer" class="form-control" :id="steps[questionStepKey].questions[0].title" :class="!validation && steps[questionStepKey].questions[0].answer.length === 0 ? 'border border-danger' : ''">
              </div>
              <div class="form-group text-justify col-md-6">
                <label :for="steps[questionStepKey].questions[1].title" v-text="steps[questionStepKey].questions[1].title"></label>
                <input :type="steps[questionStepKey].questions[1].type ?? 'text'" v-model="steps[questionStepKey].questions[1].answer" class="form-control" :id="steps[questionStepKey].questions[1].title" :class="!validation && steps[questionStepKey].questions[1].answer.length === 0 ? 'border border-danger' : ''">
              </div>
            </div>
            <div v-if="step.type" class="form-row">
              <div class="form-group text-justify col-md-6">
                <label :for="steps[questionStepKey].questions[2].title" v-text="steps[questionStepKey].questions[2].title"></label>
                <input :type="steps[questionStepKey].questions[2].type ?? 'text'" v-model="steps[questionStepKey].questions[2].answer" class="form-control" :id="steps[questionStepKey].questions[2].title" :class="!validation && steps[questionStepKey].questions[2].answer.length === 0 ? 'border border-danger' : ''">
              </div>
              <div class="form-group text-justify col-md-6 ">
                <label :for="steps[questionStepKey].questions[3].title" v-text="steps[questionStepKey].questions[3].title"></label>
                <input :type="steps[questionStepKey].questions[3].type ?? 'text'" v-model="steps[questionStepKey].questions[3].answer" class="form-control" :id="steps[questionStepKey].questions[3].title" :class="!validation && steps[questionStepKey].questions[3].answer.length === 0 ? 'border border-danger' : ''">
              </div>
            </div>

            <div class="form-group text-justify">
              <label :for="steps[questionStepKey].questions[4].title" v-text="steps[questionStepKey].questions[4].title"></label>
              <input :type="steps[questionStepKey].questions[4].type ?? 'text'" v-model="steps[questionStepKey].questions[4].answer" class="form-control" :id="steps[questionStepKey].questions[4].title" :class="!validation && steps[questionStepKey].questions[4].answer.length === 0 ? 'border border-danger' : ''">
            </div>

            <div class="form-group text-justify">
              <div class="form-check" :class="!validation && steps[questionStepKey].questions[5].answer.length === 0 ? 'border border-danger' : ''">
                <input class="form-check-input" :type="steps[questionStepKey].questions[5].type ?? 'text'" v-model="steps[questionStepKey].questions[5].answer" :id="steps[questionStepKey].questions[5].title">
                <label class="form-check-label" :for="steps[questionStepKey].questions[5].title" v-text="steps[questionStepKey].questions[5].title"></label>
              </div>
            </div>

          </div>

          <div v-else v-for="(data, key) in step.questions" v-bind:key="data.id">
            <div :class="!validation && data.answer.length === 0 ? 'border border-danger' : ''">
              <h4 class="mb-3 mt-4 w-100 text" :class="data.description ? 'step-0' : ''" v-if="data.answers.length > 0">
                {{ data.title }}
                <svg v-if="data.description" @click="toggleShow(data)" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle clickable" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                </svg>
              </h4>
              <p v-if="data.description" v-show="!data.hide" class="step-0 p-2" style="border: 1px solid" v-html="data.description"></p>
              <p v-if="data.subtitle" class="step-0" v-html="data.subtitle"></p>
              <div v-if="data.type && data.type === 'images'" class="row blocks-wrapper block-with-icons p-1">
                <label
                    class="col-6 mb-2 box-shadow clickable images-block labels"
                    v-for="(answer, key) in data.answers"
                    v-bind:key="answer"
                    :class="[data.images[key] || answer.split(' - ')[1] ? 'col-md-4' : 'col-md-3']"
                >
                  <div class="card p-3 h-100" :class="data.answer.indexOf (answer) !== -1 ? 'checked' : ''">
                      <div class="input-block" style="margin-top: auto; margin-bottom: auto; min-height: 30px">
                    <input :name="data.title" :type="data.multi ? 'checkbox' : 'radio'" :value="answer" :id="answer" v-model="data.answer" tabindex="1" class="d-none">
                    <div class="block-item-wrapper" :class="!data.images[key] ? 'pt-3 pb-3 mb-0':''">
                      <span class="block-item">
                        <span class="block-item__title text" :class="data.images[key] ? 'narrow_text' : ''">{{ answer.split(' - ')[0] }}</span>
                        <span class="block-item__subtitle"><br v-if="answer.split(' - ')[1]" />{{ answer.split(' - ')[1] }}</span>
                        <span class="block-item__image">
                          <img v-if="data.images[key]" width="100" height="80" :src="frontendHost + data.images[key]" class="attachment-small size-small" alt="">
                        </span>
                      </span>
                    </div>
                  </div>
                  </div>
                </label>
              </div>
              <div v-else-if="data.type && data.type === 'range'">
                <input
                    type="range"
                    class="form-range clickable"
                    style="width: 100%"
                    min="0"
                    :max="data.answers.length - 1"
                    step="1"
                    v-model="data.index"
                    @input="range(key)"
                >
                <p class="block-item__title text" v-text="data.answer[0]"></p>
              </div>
              <select
                  v-else-if="data.answers.length > 0"
                  class="custom-select d-block w-100 mb-3 mt-5"
                  v-model="data.answer"
                  required=""
                  :multiple="data.multi"
              >
                <option v-for="answer in data.answers" v-bind:key="answer" v-text="answer"></option>
              </select>
            </div>
            <hr class="mb-4">
          </div>
          <p v-if="step.end" v-text="step.end"></p>
          <button type="button" class="btn btn-primary mb-5" @click="getToStep(null)" v-text="nextText"></button>
        </div>
      </form>
    </div>
    <img v-if="thanks" width="110" height="50" :src="frontendHost + logoImage" class="mt-4" alt="">
    <div v-if="thanks" class="thanks">
      <h3 style="text-align: center;" class="text" v-text="finish_title"></h3>
      <p class="thanks-text" v-html="finish_text"></p>
      <br>
      <p class="thanks-text" v-text="finish_name"></p>
      <p class="thanks-text">
        <a :href="'mailto:' + finish_email" v-text="finish_email">grzegorz_l@ht.poznan.pl</a>
      </p>
      <p class="thanks-text" v-html="finish_phone"></p>
    </div>

    <div class="col-md-8 order-md-1 d-block" v-if="recommendationStep">
      <img width="110" height="50" :src="frontendHost + logoImage" class="mt-4" alt="">
      <h4 class="mb-3 mt-4 w-100 text" v-text="recommendationText"></h4>
      <h6 v-text="recommendation" class="mb-5"></h6>
      <hr class="mb-4">
      <button type="button" class="btn btn-primary" @click="getToStep(5)" v-text="nextText"></button>
    </div>

  </div>
</template>
<style scoped>
#box_main_products_app .border-danger {

  border-radius: 5px;
}
 .form-check{
  padding: 10px;
  display: flex;
}
.form-check-label{
  margin-left: 10px;
}
.form-check-input{
  margin-left: -12px !important;
  margin-top: 3px !important;
}
label{
  -webkit-tap-highlight-color: transparent;
}
.nav-link{
  cursor: pointer;
}
.btn, .nav-item {
  border-radius: unset;
  line-height: 1.0;
}
.btn {
  background-color: #0091d4;
  border: 1px solid #0091d4;
}
.checked {
  box-shadow: 0 0 0 3px #0091d4!important;
}
.text {
  color: #0091d4;
  font-weight: 700;
}
.check {
  max-width: 250px;
}
.thanks {
  align-content: center;
  align-items: center;
  margin: 50px auto;
}
.thanks-text {
  text-align: center;
  padding-left: 20px;
  padding-right: 20px;
}
.step-0 {
  text-align: initial;
}
.clickable {
  cursor:pointer;
}
@media screen and (max-width: 992px) {
  .col-md-4.card.mb-2.mr-2.ml-auto.box-shadow {
    margin-left: .5rem!important;
  }
  .col-md-4.card.mb-2.mr-auto.ml-2.box-shadow {
    margin-right: .5rem!important;
  }
  .images-block {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 41.666667%;
    flex: 0 0 41.666667%;
    max-width: 41.666667%;
  }
  .images-block img {
    width: 100%;
    height: 100%;
    padding-bottom: 5px;
  }
  .row.blocks-wrapper.block-with-icons.ml-1 {
    padding-top: 10px;
    overflow: scroll;
  }
  .form-group.text-justify.col-md-6.pl-3{
    padding-left: 5px!important;
  }
  .form-group.text-justify.col-md-6.pr-3{
    padding-right: 5px!important;
  }
}
.attachment-small {
  margin-top: 10px;
  margin-bottom: 10px;
}
.labels {
  max-width: 234px;
}
.narrow_text {
  width: 90%;
  margin-left: auto;
  margin-right: auto;
  display: block;
}
li {
  list-style-type: none!important;
}
</style>
<script>
import axios from "axios";

export default {
  name: 'WidgetQuestions',
  data: function() {
    let answers = {
      step1_1_1: 'Small databases',
      step1_1_2: 'Virtual machine',
      step1_1_3: 'Databases',
      step1_1_4: 'Data backup',
      step1_1_5: 'Virtualization of desktops',
      step1_1_6: 'File server',
      step1_1_7: 'Monitoring system',
      step1_1_8: 'Analytics and HPC systems',
      step1_1_9: 'SAP/ERP systems',

      step2_1_1: 'SSD0',
      step2_1_2: 'SSD1',
      step2_1_3: 'SSD2',
      step2_1_4: 'SSD3',
      step2_1_5: 'SSD4',

      step2_2_1: 'up to 50 TB',
      step2_2_2: 'up to 100 TB',
      step2_2_3: 'up to 500 TB',
      step2_2_4: 'up to 1 PB',
      step2_2_5: 'up to 5 PB',
      step2_2_6: 'up to 35 PB',
      step2_2_7: 'up to 300 PB',
      step2_2_8: 'up to 700 PB',

      step2_3_1: 'up to 48',
      step2_3_2: 'up to 144',
      step2_3_3: 'up to 180',
      step2_3_4: 'up to 480',
      step2_3_5: 'up to 720',
      step2_3_6: 'up to 1440',
      step2_3_7: 'above 1440',

      step3_1_1: 'normal',
      step3_1_2: 'medium',
      step3_1_3: 'large',
      step3_1_4: 'biggest',

      step3_2_1: 'deduplication',
      step3_2_2: 'synchronous replication',
      step3_2_3: 'asynchronous replication',
      step3_2_4: 'Snapshots to Veeam, Commvault',
      step3_2_5: 'file-level support (CIFS/SMB)',
      step3_2_6: 'NVMe drive support',
      step3_2_7: 'cloud replication',
      step3_2_8: 'disk encryption',
      step3_2_9: 'Storage WORM (protection against rewriting - including ransomware)',
      step3_2_10: 'ability to combine different types of drives',
      step3_2_11: 'versatility',
      step3_2_12: 'scale in',
      step3_2_13: 'scale out',
      step3_2_14: 'Integration with applications',
      step3_2_15: 'cloud backup',
      step3_2_16: 'S3 object protocol',

      step3_3_1: 'S3 10 Gb',
      step3_3_2: 'S3 25 Gb',
      step3_3_3: 'S4 16 Gb',
      step3_3_4: 'S4 32 Gb',
      step3_3_5: 'S5 100 Gb',
      step3_3_6: 'S6 1 Gb',
      step3_3_7: 'S7',

      step0_1_1: 'Basic databases, backup, monitoring',
      step0_1_2: 'Larger databases, higher scalability',

      step0_2_1: 'Performance up to 600,000 IOPS, supports NL-SAS disk shelves',
      step0_2_2: 'Performance up to 2,000,000 IOPS, supports NL-SAS disk shelves',

      step0_3_1: 'Small and medium enterprises requiring easy deployment and optimization',
      step0_3_2: 'Fully flash-based system for handling applications requiring large capacity for imaging and medical research, multimedia production and entertainment, EDA, and backup or archiving',
      step0_3_3: 'Large and global enterprises requiring seamless scalability of performance and capacity',

      step0_4_1: 'MODEL A150 - upcoming smallest model, scalable to transition from hybrid/HDD to all-flash storage, supports VMware database applications and latency-insensitive file environments, serves as secondary storage for recovery and backup purposes',
      step0_4_2: 'MODEL A250 - basic midrange class array with large expansion capabilities',
      step0_4_3: 'MODEL A250 All SAN - full ONTAP functionality for block protocols (no file protocol), dual-controller simultaneous write',

      step0_5_1: 'MODEL A400',
      step0_5_2: 'MODEL A800',
      step0_5_3: 'MODEL A900',
    };

    return {
      steps: [
        {
          id: 0,
          active: true,
          config: 'model',
          title: 'Choose a matrix model',
          end: 'There is also a line of TEST MODELS C250, C400, C800, C900 - based only on 15TB LC drives (lower disk price, longer latency, one capacity).',
          questions: [
            {
              title: 'TEST Seria E',
              multi: true,
              answers: [
                answers.step0_1_1,
                answers.step0_1_2,
              ],
              type: 'images',
              images: [],
              answer: [],
              subtitle: '<b>Hybrid Block Matrices</b>: the basic disk system for small and medium-sized enterprises',
              description: 'This is the basic matrix system: simple and reliable. From medium-sized companies handling data-intensive applications such as analytics, video surveillance, and disk-based backups, to small businesses and remote offices that need performance for their dedicated applications under varying workloads. In addition to solid performance, the E series enables flexible and cost-effective cloud backup and data recovery, and is equipped with a modern, browser-based graphical user interface that allows for easy, flexible administration and fast data access.',
              hide: true,
            },
            {
              title: '',
              multi: true,
              answers: [
                answers.step0_2_1,
                answers.step0_2_2,
              ],
              type: 'images',
              images: [],
              answer: [],
              subtitle: '<b>All-Flash Block Matrices</b>: microsecond response for demanding applications, 100Gb network support, and 32Gb NVMe/FC',
              description: '',
              hide: true,
            },
            {
              title: 'Test MODEL',
              multi: true,
              answers: [
                answers.step0_3_1,
                answers.step0_3_2,
                answers.step0_3_3,
              ],
              type: 'images',
              images: [],
              answer: [],
              subtitle: '<b>Hybrid Block-File Matrices</b>: Test FAS storage arrays provide customers with a balance between performance and capacity. Optimized for deployment and management, Test FAS systems offer the flexibility required to support future growth and cloud integration. With highly available hardware and efficient software, FAS systems economically ensure data protection, security, and scalability (up to 24 controllers in some models).',
              description: 'Test ONTAP software-based systems - the #1 customer-tested operating system that provides security, simplicity, and scalability for hybrid cloud deployments, enabling:\n' +
                  '<br>◦ Optimization for multiple database applications (performance optimization plugins)\n' +
                  '<br>◦ Snapshots for most backup applications\n' +
                  '<br>◦ Inline deduplication\n' +
                  '<br>◦ Compression\n' +
                  '<br>◦ Compaction\n' +
                  '<br>◦ Thin provisioning',
              hide: true,
            },
            {
              title: '',
              multi: true,
              answers: [
                "test_answer1",
                "test_answer2",
                "test_answer3"
              ],
              type: "images",
              images: [],
              answer: [],
              subtitle: '<b>All-Flash Block-File Matrices</b>: corporate databases, data analytics, artificial intelligence (AI), machine learning (ML). These matrices not only provide consistently low latency under the most demanding workloads, but also maintain performance even when optimization technologies are enabled. The A series models deliver best-in-class integrated data protection, leading cyber resilience, and seamless cloud backup and data recovery.',
              description: '',
              hide: true,
            },
            {
              title: '',
              multi: true,
              answers: [
                "test_answer1",
                "test_answer2",
                "test_answer3"
              ],
              type: "images",
              images: [],
              answer: [],
              subtitle: 'Models for handling large and very large systems with varying performance characteristics.',
              description: '',
              hide: true,
            },
          ],
        },
        {
          id: 1,
          active: true,
          config: 'configurator',
          questions: [
            {
              title: 'Primary use',
              multi: false,
              type: 'images',
              answers: [
                answers.step1_1_1,
                answers.step1_1_2,
                answers.step1_1_3,
                answers.step1_1_4,
                answers.step1_1_5,
                answers.step1_1_6,
                answers.step1_1_7,
                answers.step1_1_8,
                answers.step1_1_9,
              ],
              answer: [],
              images: [
                'images/ssd.png',
                'images/ssd.png',
                'images/ssd.png',
                'images/ssd.png',
                'images/ssd.png',
                'images/ssd.png',
                'images/ssd.png',
                'images/ssd.png',
                'images/ssd.png'
              ],
            },
          ],
        },
        {
          id: 2,
          active: false,
          questions: [
            {
              title: 'Types of discs',
              multi: true,
              type: 'images',
              answers: [
                answers.step2_1_1,
                answers.step2_1_2,
                answers.step2_1_3,
                answers.step2_1_4,
                answers.step2_1_5,
              ],
              answer: [],
              images: [
                'images/ssd.png',
                'images/ssd.png',
                'images/ssd.png',
                'images/ssd.png',
                'images/ssd.png',
              ],
            },
            {
              title: 'Matrix capacity',
              multi: false,
              type: 'range',
              answers: [
                answers.step2_2_1,
                answers.step2_2_2,
                answers.step2_2_3,
                answers.step2_2_4,
                answers.step2_2_5,
                answers.step2_2_6,
                answers.step2_2_7,
                answers.step2_2_8,
              ],
              answer: [answers.step2_2_1],
              index: 0,
            },
            {
              title: 'Maximum number of disks',
              multi: false,
              type: 'range',
              answers: [
                answers.step2_3_1,
                answers.step2_3_2,
                answers.step2_3_3,
                answers.step2_3_4,
                answers.step2_3_5,
                answers.step2_3_6,
                answers.step2_3_7,
              ],
              answer: [answers.step2_3_1],
              index: 0,
            },
          ],
        },
        {
          id: 3,
          active: false,
          config: 'configurator',
          questions: [
            {
              title: 'Efficiency',
              multi: false,
              type: 'images',
              answers: [
                answers.step3_1_1,
                answers.step3_1_2,
                answers.step3_1_3,
                answers.step3_1_4,
              ],
              answer: [],
              images: [],
            },
            {
              title: 'Required functionality',
              multi: true,
              type: 'images',
              answers: [
                answers.step3_2_1,
                answers.step3_2_2,
                answers.step3_2_3,
                answers.step3_2_4,
                answers.step3_2_5,
                answers.step3_2_6,
                answers.step3_2_7,
                answers.step3_2_8,
                answers.step3_2_9,
                answers.step3_2_10,
                answers.step3_2_11,
                answers.step3_2_12,
                answers.step3_2_13,
                answers.step3_2_14,
                answers.step3_2_15,
                answers.step3_2_16,
              ],
              answer: [],
              images: [],
            },
            {
              title: 'Connection types',
              multi: true,
              type: 'images',
              answers: [
                answers.step3_3_1,
                answers.step3_3_2,
                answers.step3_3_3,
                answers.step3_3_4,
                answers.step3_3_5,
                answers.step3_3_6,
                answers.step3_3_7,
              ],
              answer: [],
              images: [],
            },
          ],
        },
        {
          id: 4,
          active: false,
          config: 'model',
          questions: [
            {
              title: 'Required functionality',
              multi: true,
              type: 'images',
              answers: [
                answers.step3_2_1,
                answers.step3_2_2,
                answers.step3_2_3,
                answers.step3_2_4,
                answers.step3_2_5,
                answers.step3_2_6,
                answers.step3_2_7,
                answers.step3_2_8,
                answers.step3_2_9,
                answers.step3_2_10,
                answers.step3_2_11,
                answers.step3_2_12,
                answers.step3_2_13,
                answers.step3_2_14,
                answers.step3_2_15,
                answers.step3_2_16,
              ],
              answer: [],
              images: [],
            },
            {
              title: 'Connection types',
              multi: true,
              type: 'images',
              answers: [
                answers.step3_3_1,
                answers.step3_3_2,
                answers.step3_3_3,
                answers.step3_3_4,
                answers.step3_3_5,
                answers.step3_3_6,
                answers.step3_3_7,
              ],
              answer: [],
              images: [],
            },
          ]
        },
        {
          id: 5,
          active: false,
          title: 'Personal data',
          subtitle: 'Your data will not be passed on or used for marketing purposes.',
          type: 'inputs',
          questions: [
            {
              title: 'First name and last name',
              multi: false,
              answers: [],
              answer: [],
            },
            {
              title: 'E-mail',
              multi: false,
              type: 'email',
              answers: [],
              answer: [],
            },
            {
              title: 'Organization',
              multi: false,
              answers: [],
              answer: [],
            },
            {
              title: 'Phone',
              multi: false,
              answers: [],
              answer: [],
            },
            {
              title: 'Additional requirements (optional)',
              multi: false,
              required: false,
              answers: [],
              answer: [''],
            },
            {
              title: 'I accept the privacy policy',
              multi: false,
              type: 'checkbox',
              answers: [],
              answer: [],
            },
          ],
        },
        {
          id: 6,
          active: false,
          questions: [],
        },
      ],
      step: 1,
      stepText: 'Step',
      nextText: 'Next',
      sendText: 'Send',
      validation: true,
      thanks: false,
      url: process.env.VUE_APP_BACKEND_API_URL,
      frontendHost: process.env.VUE_APP_FRONTEND_API_URL,
      checkImage: 'images/check.svg',
      logoImage: 'images/logo_dark.png',
      answers: answers,
      bigModelList: 'TEST1, TEST2, TEST3, TEST4, TEST5, TEST6, TEST7, TEST8, TEST9, TEST10, TEST11',
      recommendationText: 'Recommended models for you: ',
      recommendationStep: false,
      startStep: true,
      startStepText: 'TEST Configurator',
      stepTypeModel: 'model',
      stepTypeConfigurator: 'configurator',
      stepType: null,
      startConfigButton: 'Configure by application',
      startModelButton: 'Select model',
      finish_title: 'Thank you!',
      finish_text: 'We are glad that you have joined the group of people who value data security and reliability.<br><br>Our specialist will contact you to determine the detailed configuration.',
      finish_name: 'Name Lastname',
      finish_email: 'test@test.test',
      finish_phone: 'Tel. 555 44 33 22',
    }
  },
  computed: {
    recommendation(){
      let answer1step = this.steps[1].questions[0].answer,
          answer2_1step = this.steps[2].questions[0].answer,
          answer2_2step = this.steps[2].questions[1].answer,
          answer2_3step = this.steps[2].questions[2].answer,
          answer3_1step = this.steps[3].questions[0].answer,
          answer3_2step = this.steps[3].questions[1].answer,
          answer3_3step = this.steps[3].questions[2].answer;

      let model = {
        E2800: 0,
        E5700: 0,
        bigModelList: 0,
      };

      if(answer1step.indexOf(this.answers.step1_1_9)) {
        model.bigModelList++;
      } else if (
          answer1step.indexOf(this.answers.step1_1_3)
          || answer1step.indexOf(this.answers.step1_1_5)
          || answer1step.indexOf(this.answers.step1_1_8)
      ){
        model.E5700++;
      } else {
        model.E2800++;
      }

      if (
          answer2_2step.indexOf(this.answers.step2_2_1)
          || answer2_2step.indexOf(this.answers.step2_2_2)
          || answer2_2step.indexOf(this.answers.step2_2_3)
          || answer2_2step.indexOf(this.answers.step2_2_4)
      ){
        model.E2800++;
      } else {
        model.E5700++;
        model.bigModelList++;
      }

      if (answer2_1step.indexOf(this.answers.step2_1_1)){
        model.bigModelList++;
      } else {
        model.E2800++;
        model.E5700++;
      }

      if(answer2_3step.indexOf(this.answers.step2_3_4)) {
        model.E5700++;
      } else if (
          answer2_3step.indexOf(this.answers.step2_3_1)
          || answer2_3step.indexOf(this.answers.step2_3_2)
          || answer2_3step.indexOf(this.answers.step2_3_3)
      ){
        model.E2800++;
        model.E5700++;
      } else {
        model.bigModelList++;
      }

      if(answer3_1step.indexOf(this.answers.step3_1_1)) {
        model.E2800++;
        model.E5700++;
      } else if (
          answer3_1step.indexOf(this.answers.step3_1_2)
          || answer3_1step.indexOf(this.answers.step3_1_3)
      ){
        model.E5700++;
      } else {
        model.bigModelList++;
      }

      if(
          answer3_2step.indexOf(this.answers.step3_2_2)
          || answer3_2step.indexOf(this.answers.step3_2_3)
          || answer3_2step.indexOf(this.answers.step3_2_8)
          || answer3_2step.indexOf(this.answers.step3_2_10)
      ){
        model.E2800++;
        model.E5700++;
        model.bigModelList++;
      }
      if(answer3_2step.indexOf(this.answers.step3_2_9)) {
        model.E2800++;
      } else if(
          answer3_2step.indexOf(this.answers.step3_2_7)
          || answer3_2step.indexOf(this.answers.step3_2_11)
          || answer3_2step.indexOf(this.answers.step3_2_15)
      ){
        model.E5700++;
      } else {
        model.bigModelList++;
      }

      if(answer3_3step.indexOf(this.answers.step3_3_5)) {
        model.E5700++;
        model.bigModelList++;
      } else {
        model.E2800++;
        model.E5700++;
      }

      return this.sortRecommendationToText(model);
    },
    filteredSteps() {
      return this.steps.filter((item) => {
        return !item.config || item.config && item.config === this.stepType;
      })
    },
    questionStepKey() {
      return Object.keys(this.steps).find(key => this.steps[key].type === 'inputs');
    },
  },
  methods: {
    getToStep(stepId) {
      if (this.checkAnswersStep(stepId) && !this.thanks) {
        stepId = stepId === null ? this.getNextStep() : stepId;

        this.steps.forEach(function(step){
          step.active = false;
        });
        this.steps.find(step => step.id === stepId).active = true
        this.step = stepId;

        if(stepId === 6) {
          this.sendData();
        }
      }

      return false;
    },
    checkAnswersStep(stepId){
      stepId = this.getPrevStep(stepId);
      stepId = stepId === 0 && this.stepType === this.stepTypeConfigurator ? 1 : stepId;
      let validating = stepId !== 0;

      if(stepId === 0) {
        Object.values(this.filteredSteps.find(step => step.id === stepId).questions).forEach(function(question){
          if (question.answer.length > 0) {
            validating = true;
          }
        });
      } else {
        if (!this.filteredSteps.find(step => step.id === stepId)) {
          validating = false;
        } else {
          Object.values(this.filteredSteps.find(step => step.id === stepId).questions).forEach(function(question){
            if (question.answer.length === 0) {
              validating = false;
            }
          });
        }
      }

      return this.validation = validating;
    },
    sendData() {
      let data = [];
      this.filteredSteps.forEach(function(step){
        Object.values(step.questions).forEach(function(question){
          let title = question.title ? question.title : 'model';
          data[title] = question.answer;
        });
      });

      axios
          .post(this.url, {'questions': btoa(unescape(encodeURIComponent(JSON.stringify(Object.entries(data))))) })
          .catch(error => console.log(error));

      this.thanks = true;
    },
    range(questionIndex) {
      let stepKey = Object.keys(this.steps).find(key => this.steps[key].id === this.step);
      let index = this.steps[stepKey].questions[questionIndex].index;

      this.steps[stepKey].questions[questionIndex].answer = [this.steps[stepKey].questions[questionIndex].answers[index]];
    },
    sortRecommendationToText(array){
      let max = Object.values(array).sort()[ Object.keys(array).length - 1 ];
      let itemsKeys = Object.keys(array).filter(cur => { return array[cur] === max });
      let text = '';

      if (itemsKeys.length > 0) {
        text = itemsKeys.join(', ');
        text = text.replace(/bigModelList/i, this.bigModelList);
      }

      return text;
    },
    setStartSteps(type){
      this.startStep = false;
      this.stepType = type;
    },
    toggleShow(data) {
      data.hide = !data.hide;
    },
    getNextStep() {
      let key = (parseInt(Object.keys(this.filteredSteps).find(key => this.filteredSteps[key].active === true)) + 1);
      return this.filteredSteps[key].id;
    },
    getPrevStep(stepId) {
      let key = stepId === null
          ? parseInt(Object.keys(this.filteredSteps).find(key => this.filteredSteps[key].active === true))
          : (parseInt(Object.keys(this.filteredSteps).find(key => this.filteredSteps[key].id === stepId)) - 1);

      key = key === -1 ? 1 : this.filteredSteps[key].id;

      return stepId === 0 ? stepId : key;
    },
  }
}
</script>
