<template>
  <footer class="shadow-lg border-top border-primary bg-light py-5">
    <b-container>
      <b-row>
        <b-col md="6" class="py-2">
          <h5>Showroom address</h5>
          <ul>
            <li>Branch 1: xxxxx xxx Street, xxx Ward, xxxx District, xxxxx City</li>
            <li>Branch 2: xxxxx xxx Street, xxx Ward, xxxx District, xxxxx City</li>
          </ul>
          <h5>Contact</h5>
          <ul>
            <li>Hotline: xxxx-xxx-xxx</li>
            <li>Warranty: xxxx-xxx-xxx - Branch xxx</li>
            <li>Emalil: <a href="">xxxxxxxxxxxxxx</a></li>
            <li>Website: <a href="">xxxxxxxxxxxxxx</a></li>
            <li>Facebook: <a href="">xxxxxxxxxxxxx</a></li>
          </ul>
        </b-col>
        <b-col md="6" class="py-2">
          <h5>Main brand location</h5>
          <div class="border border-primary mt-2 shadow">
            <b-embed
              type="iframe"
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1010.9804522913864!2d105.78001343543148!3d10.033419783479948!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x27e73181695218ab!2zVHJ1bmcgdMOibSBDw7RuZyBuZ2jhu4cgUGjhuqduIG3hu4FtIMSQ4bqhaSBo4buNYyBD4bqnbiBUaMah!5e0!3m2!1svi!2s!4v1590692945371!5m2!1svi!2s"
              allowfullscreen
            />
          </div>
        </b-col>
      </b-row>
      <hr />
      <b-row>
        <b-col class="text-center py-2">
          <strong>
            MIT License, Copyright &copy; 2020 Daomtthuan
          </strong>
          <p>Development platform</p>
          <b-img src="/images/platform/php.png" height="30" class="mx-1" />
          <b-img src="/images/platform/nuxt.png" height="30" class="mx-1" />
          <b-img src="/images/platform/nodejs.png" height="30" class="mx-1" />
          <b-img src="/images/platform/typescript.png" height="30" class="mx-1" />
          <b-img src="/images/platform/sass.png" height="30" class="mx-1" />
          <b-img src="/images/platform/bootstrap-vue.png" height="30" class="mx-1" />
          <b-img src="/images/platform/font-awesome.png" height="30" class="mx-1" />
        </b-col>
      </b-row>
    </b-container>
  </footer>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component
  export default class Footbar extends Vue {}
</script>
