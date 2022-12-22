<template>
    <div class="row">
        <div class="col-12 mb-2 text-end">
            <router-link :to='{name:"shipperAdd"}' class="btn btn-primary">Create</router-link>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Shippers</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Primary Contact Name</th>
                                    <th>Primary Contact Number</th>
                                    <th>Contacts</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody v-if="shippers.length > 0">
                                <tr v-for="(shipper,key) in shippers" :key="key">
                                    <td>{{ key+1 }}</td>
                                    <td>{{ shipper.name }}</td>
                                    <td>{{ shipper.address }}</td>
                                    <td>{{ shipper.primary.name }}</td>
                                    <td>{{ shipper.primary.number }}</td>
                                    <td>
                                        <b-button size="sm" variant="warning" @click="loadContactInfo(shipper.contacts,shipper.name)">
                                            Details
                                        </b-button>
                                    </td>
                                    <td>
                                        <router-link :to='{name:"shipperEdit",params:{id:shipper.id}}' class="btn btn-success">Edit</router-link>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="4" align="center">No Shippers Found.</td>
                                </tr>
                            </tbody>
                        </table>
                        <b-modal :id="'modal-1'" centered hide-backdrop  @hidden="clearContactInfo" button-size="sm" >
                            <template slot="modal-title">Shipper - {{ shipper }}</template>
                            <table class="table">
                                <tr>
                                    <th>Contact Name</th>
                                    <th>Contact Number</th>
                                </tr>
                                <tbody v-if="contacts.length > 0">
                                    <tr v-for="(contact,key) in contacts.slice().reverse()" :key="key">
                                        <td :class="contact.primary == 1 ? 'bg-warning' : ''" >{{ contact.name }}</td>
                                        <td :class="contact.primary == 1 ? 'bg-warning' : ''">{{ contact.number }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </b-modal>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    name:"shippers",
    data(){
        return {
            shippers:[],
            contacts: {},
            shipper:'',
        }
    },
    mounted(){
        this.getShippers()
    },
    methods:{
        async getShippers(){
            await this.axios.get('/api/shipper').then(response=>{
                this.shippers = response.data
            }).catch(error=>{
                console.log(error)
                this.shippers = []
            })
        },
        loadContactInfo(contacts,shipper) {
            this.contacts = contacts;
            this.shipper = shipper;
            this.$bvModal.show("modal-1")
        },
        clearContactInfo() {
            this.contacts = {}
            this.shipper = '';
        }
    }
}
</script>