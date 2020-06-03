<template>
  <article class="text-justify">
    <h2>Warranty Policy</h2>
    <hr />
    <h4>Provisions on warranty</h4>
    <dl>
      <dt>Defective products manufactured by the manufacturer:</dt>
      <dd>
        <ul>
          <li>Warranty standards of the company. Warranty period is within 7 working days &lpar;excluding Saturday and Sunday&rpar;.</li>
        </ul>
      </dd>
      <dt>Defective products due to user:</dt>
      <dd>
        <ul>
          <li>We can receive repair and replacement support depending on the specific case &lpar;customers pay the repair fee if any&rpar;.</li>
          <li>We reserve the right to refuse the warranty and return the defective product back to the customer.</li>
        </ul>
      </dd>
    </dl>
    <h4>Working information of Warranty Department</h4>
    <ul>
      <li>Hotline: xxxx-xxx-xxx - branch xxx</li>
      <li>Email: xxx.xxxx@gmail.com</li>
      <li>Time to receive and pay warranty: 10:00 - 18:00 on working days of the week &lpar;except Sunday&rpar;.</li>
    </ul>
    <h4>Product warranty conditions &lpar;applicable to manufacturers with defective products&rpar;</h4>
    <ul>
      <li>Products are still in the warranty period of KonKon.</li>
      <li>Products are stamped with genuine warranty and KonKon.</li>
      <li>Warranty stamp is not blurred.</li>
      <li>Series Number of the product barcode must be intact.</li>
      <li>
        The product is not subject to physical deformation such as scratches, scratches, convex, dented, dented, distorted, cracked, broken due to dropping,
        being hit, due to wrong transport / installation.
      </li>
      <li>Products must not be moldy, rusted, damp, penetrating liquid, yellowed, blurry, and erasable</li>
      <li>The product is not infested by rats, cockroaches, insects...</li>
      <li>The product is not arbitrarily removed, repaired or lost by the manufacturer.</li>
    </ul>
    <h4>Customer support policy</h4>
    <ul>
      <li>
        Sticker "GOLD WARRANTY 6 MONTHS": Products sold by KonKon with sticker "Gold Warranty 6 months" will be renewed immediately within the first 6 months
        from the date of purchase if errors arise &lpar;Customers need Keep the box and accessories intact with the product&rpar;.
      </li>
      <li>
        Immediate renewal of defective products &lpar;applicable within the first 7 days of purchase&rpar;: All KonKon products sold are supported to
        immediately innovate within the first 7 days of purchase if incurred error.
      </li>
      <li>
        Service "HOME WARRANTY": with the whole assembly machine at KonKon will be supported to take the service to take place for warranty and return to the
        place after the warranty is completed. The service is free of charge during the warranty period of the device.
      </li>
      <li>Support return fee warranty for customers in areas outside xxx xxx city.</li>
    </ul>
  </article>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';
  import App from '~/plugins/app';

  @Component({
    scrollToTop: true,
  })
  export default class PagePolicyWarranty extends Vue {
    public mounted() {
      App.ready(this);
    }
  }
</script>
