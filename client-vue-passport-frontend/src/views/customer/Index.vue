<template>
   <div class="container mt-5">
      <div class="row">
         <div class="col-md-12">
            <div class="card border-0 rounded shadow">
               <div class="card-body">
                  <h4>List of Customers</h4>
                  <hr>
                  <router-link :to="{name: 'customer.create'}" class="btn btn-md btn-success">Add Customer</router-link>
                  <table class="table table-striped table-bordered mt-4">
                     <thead class="thead-dark">
                        <tr>
                           <th scope="col">Name</th>
                           <th scope="col">Email</th>
                           <th scope="col">Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr v-for="(customer, index) in customers" :key="index">
                           <td>{{ customer.name }}</td>
                           <td>{{ customer.email }}</td>
                           <td class="text-center">
                              <router-link :to="{name: 'customer.edit', params:{id: customer.id }}" class="btn btn-sm btn-primary mr-1"> Edit</router-link>
                              <button class="btn btn-sm btn-danger ml-1">Delete</button>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</template>

<script>
   import axios from 'axios'
   import { onMounted, ref } from 'vue'

   export default {
      setup() {
         let token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZDA0MTk3M2E5Mzk4ZWY3MDE3ZmUxYTBhOTNkN2YzMmRiMzBkZjFkYzBkNWY5YzljY2Y0YTdlZDQxMzllZDA3ZWRlODkzZGUyYTU4NWY3ZjkiLCJpYXQiOjE2MDg4MjMzMDMsIm5iZiI6MTYwODgyMzMwMywiZXhwIjoxNjQwMzU5MzAzLCJzdWIiOiI2Iiwic2NvcGVzIjpbXX0.b5OMU9hcx21rDjA-NQoLUiPBAVkC-YQUX2ysC18gF0sa0VIO9V66UjiJEQI8UK6pQwgMmSv6sRxgRnPiRp6GPbXEwkvteVLHEgx9kw03agxUVvB32A7yRxMdXjCh3hiBzEoKlgwVc08GLpWcnoB7T6lsPeYVvhOCW0pqV4OojAmENQsoalxajof4yg-EOKaLmi-ymiexOUTXVjDns9CeZ4ALnKmjMIRNWAShLkq2oNs2WF25xWauZk46FvkUNHoRpUqIJa-W1jRt2pIzaQATSKPzRKM0zl5K2-KjTNNjgJiiZv6tdSPZWOYq6FHfpZox67A7guRFqXijJSBEjcOpWYpZbgIEQ_z70uukEZg8C6rKMBY3qyhQw5GgLaRPXV-sY2RK4L7_IH6bGkYbgR2AJRmnTsZoocMp27JaQhcBlhUiY2KVjdiyTyGnZYIrizvQSRDIldld62djt-JZE-pAXUTZj6993e51pL-DelaC-ZXuMlZK4HMVW1hqneUS4gPQaWNmQBINLP6UPScFSqyu-bMWtvmCK39UW5v8GqLVKUaNMEYbO7qEXSpxRtopoVHsbJQwo8ynGpomk9kE0zJEqrAWqA57cZU5_0WDn1IOz0br7Qzrt56AP49mAr3MBpyZPEKKqYbmgRDcGc_4gbR6qHSEYMjILonbE-8DmdC4RBk'
         let customers = ref([])
         onMounted(() => {
            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            axios.get('http://localhost:8000/api/customers')
            .then(response => {
               customers.value = response.data.result
            }).catch(error => {
               console.log(error.response.data)
            })
         })

         return {
            customers
         }
      }
   }
</script>

<style>
    body{
        background: lightgray;
    }
</style>