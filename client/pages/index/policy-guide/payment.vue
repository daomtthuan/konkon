<template>
  <article class="text-justify">
    <h2>Payment Guide</h2>
    <hr />
    <h4>Pay directly at Showroom</h4>
    <ol>
      <li>You can pay by cash or swipe a bank card.</li>
      <li>Cashier will directly guide customers to pay the order.</li>
      <li>Immediately after the payment, customers will be guided by sales staff to check and receive goods.</li>
    </ol>
    <h4>Pay at delivery</h4>
    <ol>
      <li>
        Customers pay cash or bank transfer the amount corresponding to the order. Additional shipping charges may be incurred if the location is not within the
        free delivery area or the use of additional shipping services &lpar;prior notice to you&rpar;.
      </li>
      <li>
        Please check the goods before payment. Any problems arising during the process of receiving payment, please contact Hotline xxxx-xxx-xxx to be checked
        and supported by sales staff.
      </li>
      <li>Immediately after the payment, customers will be guided by sales staff to check and receive goods.</li>
      <li>
        If you are in a province outside xxx xxx City, you need to transfer online to KonKon first, after receiving the money, KonKon will conduct a call back
        to confirm delivery information and send shipping procedures for customers.
      </li>
    </ol>
    <h4>Bank account information of KonKon</h4>
    <h5>Vietcombank</h5>
    <img src="/images/bank/vietcombank.png" alt="" class="my-3" height="50px" />
    <ul>
      <li>Account holder: xxx xxxx xxxx xxxxx</li>
      <li>Branch: xxx xxx xxxxx, xxxx xxx, xxxxx</li>
      <li>Account number: xxxx-xxxx-xxxx-xxxx</li>
      <li>Domestic card number: xxxx-xxxx-xxxx-xxxx</li>
    </ul>
    <h5>ACB bank</h5>
    <img src="/images/bank/acbbank.png" alt="" class="my-3" height="50px" />
    <ul>
      <li>Account holder: xxx xxxx xxxx xxxxx</li>
      <li>Branch: xxx xxx xxxxx, xxxx xxx, xxxxx</li>
      <li>Account number: xxxx-xxxx-xxxx-xxxx</li>
      <li>Domestic card number: xxxx-xxxx-xxxx-xxxx</li>
    </ul>
    <h5>Sacombank</h5>
    <img src="/images/bank/sacombank.png" alt="" class="my-3" height="50px" />
    <ul>
      <li>Account holder: xxx xxxx xxxx xxxxx</li>
      <li>Branch: xxx xxx xxxxx, xxxx xxx, xxxxx</li>
      <li>Account number: xxxx-xxxx-xxxx-xxxx</li>
      <li>Domestic card number: xxxx-xxxx-xxxx-xxxx</li>
    </ul>
    <b>Please note: transfer with the bank to save money transfer costs</b>
  </article>
</template>

<script lang="ts">
  import { Component, Vue } from 'nuxt-property-decorator';

  @Component({
    scrollToTop: true,
  })
  export default class PageGuidePayment extends Vue {}
</script>
