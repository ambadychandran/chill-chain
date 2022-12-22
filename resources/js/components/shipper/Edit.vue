<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Update Shipper</h4>
                </div>
                <div class="card-body">
                    <form @submit.prevent="update">
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
                                    <input type="text" class="form-control" v-model="shipper.primary.name">
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="form-group">
                                    <label>Primary contact number</label>
                                    <input type="number" class="form-control" v-model="shipper.primary.number">
                                </div>
                            </div>
                        </div>
                        <div class="row" v-for="(contact, c) in shipper.contacts" :key="c">
                            <div class="col-6 mb-2">
                                <div class="form-group">
                                    <label>Contact Name</label>
                                    <input type="text" class="form-control" v-model="contact.name">

                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="form-group">
                                    <label>Contact Number</label>
                                    <input type="number" class="form-control" v-model="contact.number">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Update</button>
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
    name:"update-shipper",
    data(){
        return {
            shipper:{
                name:"",
                address:"",
                primary:{},
                contacts:{},
                _method:"patch",
            }
        }
    },
    mounted(){
        this.showShipper()
    },
    methods:{
        async showShipper(){
            await this.axios.get(`/api/shipper/${this.$route.params.id}`).then(response=>{
                const { name, address, primary,contacts } = response.data
                this.shipper.name = name
                this.shipper.address = address
                this.shipper.primary = primary
                this.shipper.contacts = contacts
            }).catch(error=>{
                console.log(error)
            })
        },
        async update(){
            await this.axios.post(`/api/shipper/${this.$route.params.id}`,this.shipper).then(response=>{
                this.$router.push({name:"shipperList"})
            }).catch(error=>{
                console.log(error)
            })
        },
    }
}
</script>