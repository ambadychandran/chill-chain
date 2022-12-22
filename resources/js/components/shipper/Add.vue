<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Shipper</h4>
                </div>
                <div class="card-body ">
                    <form @submit.prevent="create">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" v-model="shipper.name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" v-model="shipper.address">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-2">
                                <div class="form-group">
                                    <label>Primary contact Name</label>
                                    <input type="text" class="form-control" v-model="shipper.cname">
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="form-group">
                                    <label>Primary contact number</label>
                                    <input type="number" class="form-control" v-model="shipper.cnumber">
                                </div>
                            </div>
                        </div>
                        <div class="row" v-for="(contact, c) in contacts" :key="c">
                            <div class="col-6 mb-2">
                                <div class="form-group">
                                    <label>Contact Name</label>
                                    <input type="text" class="form-control" v-model="contact.cname">

                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="form-group">
                                    <label>Contact Number</label>
                                    <input type="number" class="form-control" v-model="contact.cnumber">
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-2">
                            <button type='button' class="btn btn-outline-secondary btn-sm" @click="addNewRow">
                                Add More Contacts
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:"add-shipper",
    data(){
        return {
            shipper:{
                name:"",
                address:"",
                cname:"",
                cnumber:""
            },
            contacts: [{
                cname: '',
                cnumber: '',
            }]
        }
    },
    methods:{
        async create(){
            let data = {'shipper':this.shipper,'contact':this.contacts};
            await this.axios.post('/api/shipper',data).then(response=>{
                this.$router.push({name:"shipperList"})
            }).catch(error=>{
                console.log(error)
            })
        },
        addNewRow() {
            this.contacts.push({
                cname: '',
                cnumber: '',
            });
        }
    }
}
</script>