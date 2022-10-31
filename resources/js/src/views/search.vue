<template>
    <div class="site-wrap">
        <section class="research-screen">
           <div class="research-container">
                <div class="research-header">
                    <b-navbar toggleable="lg">
                        <b-form inline class="col-lg-9 col-md-9">
                            <label class="input-label mr-sm-2" for="inline-form-input-name">SEARCH</label>
                            <b-form-input v-model="text" class="mr-sm-2 col-lg-4 col-md-4"></b-form-input>
                            <b-form-select class="mr-sm-2 col-lg-3 col-md-3" v-model="selected" :options="options"></b-form-select>
                            <b-button class="mr-sm-2">Search</b-button>
                            <b-button classs="mr-sm-2">Next Record</b-button>
                        </b-form>
                    
                        <b-navbar-nav class="ml-auto col-lg-3 col-md-3 text-right">
                            <b-button>Clear</b-button>
                        </b-navbar-nav>
                    </b-navbar>
                </div>
           </div>
        </section>
        <section class="content-form-section mt-2">
          <div class="content-form">
            <b-card class="text-center">
              <div class="row">
                <div class="col-lg-8 col-md-8 left-card-box">
                  <b-form class="fulw-width">
                      <b-form-group class="full-width mb-2">
                        <b-row>
                          <b-col col md="6" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="inline-form-input-name">Company ID</label>
                            <b-form-input v-model="text" class="mr-sm-2 col-md-8"></b-form-input>
                          </b-col>
                          <b-col col md="6" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="inline-form-input-name">Company Type</label>
                            <b-form-select class="col-md-8" v-model="selected" :options="options"></b-form-select>
                          </b-col>
                        </b-row>
                      </b-form-group>
                      <b-form-group class="full-width mb-2">
                        <b-row>
                          <b-col col md="6" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="inline-form-input-name">Last Name</label>
                            <b-form-input v-model="text" class="mr-sm-2 col-md-8"></b-form-input>
                          </b-col>
                          <b-col col md="6" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="inline-form-input-name">First Name</label>
                            <b-form-input v-model="text" class="col-md-8"></b-form-input>
                          </b-col>
                        </b-row>
                      </b-form-group>
                      <b-form-group class="full-width mb-2">
                        <b-row class="full-box">
                          <b-col col md="12" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-2" for="inline-form-input-name">Reported Address</label>
                            <b-form-input v-model="text" class="mr-sm-2 col-md-10"></b-form-input>
                          </b-col>  
                        </b-row>
                      </b-form-group>
                      <b-form-group class="full-width mb-2">
                        <b-row>
                          <b-col col md="6" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="inline-form-input-name">City</label>
                            <b-form-input v-model="text" class="mr-sm-2 col-md-8"></b-form-input>
                          </b-col>
                          <b-col col md="3" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="inline-form-input-name">State</label>
                            <b-form-input v-model="text" class="col-md-8"></b-form-input>
                          </b-col>
                          <b-col col md="3" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4 p_all_0" for="inline-form-input-name">Zip Code</label>
                            <b-form-input v-model="text" class="col-md-8"></b-form-input>
                          </b-col>
                        </b-row>
                      </b-form-group>
                      <b-form-group class="full-width mb-2">
                        <b-row>
                          <b-col col md="6" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="inline-form-input-name">Property ID</label>
                            <b-form-input v-model="text" class="mr-sm-2 col-md-8"></b-form-input>
                          </b-col>
                          <b-col col md="6" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="inline-form-input-name">Multi-Owner</label>
                            <b-form-input v-model="text" class="col-md-3"></b-form-input>
                          </b-col>
                        </b-row>
                      </b-form-group>
                      <b-form-group class="full-width mb-2">
                        <b-row>
                          <b-col col md="6" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="inline-form-input-name">Tax ID</label>
                            <b-form-input v-model="number" class="mr-sm-2 col-md-8"></b-form-input>
                          </b-col>
                          <b-col col md="6" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="inline-form-input-name">Secondary Holder</label>
                            <b-form-input v-model="text" class="col-md-8"></b-form-input>
                          </b-col>
                        </b-row>
                      </b-form-group>
                      <b-form-group class="full-width mb-2">
                        <b-row>
                          <b-col col md="6" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="inline-form-input-name">Property Type</label>
                            <b-form-select class="col-md-8" v-model="selected" :options="options"></b-form-select>
                          </b-col>
                          <b-col col md="6" class="d-flex align-items-center inline-form-input-label">
                            
                          </b-col>
                        </b-row>
                      </b-form-group>
                  </b-form>
                </div>
                <div class="col-lg-4 col-md-4">
                  <div class="inner-highlight-column">
                    <b-form-group class="full-width mb-2">
                        <b-row>
                          <b-col col md="12" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="inline-form-input-name">Schedule</label>
                            <b-form-input v-model="text" class="mr-sm-2 col-md-8"></b-form-input>
                          </b-col> 
                        </b-row>
                    </b-form-group>
                    <b-form-group class="full-width mb-2">
                        <b-row>
                          <b-col col md="12" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="inline-form-input-name">Status</label>
                            <b-form-select class="col-md-8" v-model="selected" :options="options"></b-form-select>
                          </b-col> 
                        </b-row>
                    </b-form-group>
                    <b-form-group class="full-width mb-2">
                        <b-row>
                          <b-col col md="12" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="example-datepicker">Date Found</label>
                            <b-form-datepicker id="example-datepicker" v-model="value" class="col-md-8 text-left"></b-form-datepicker>
                          </b-col> 
                        </b-row>
                    </b-form-group>
                  </div>
                  <div class="inner-highlight-column bg-trans">
                    <b-form-group class="full-width mb-2">
                        <b-row>
                          <b-col col md="12" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="inline-form-input-name"><strong>Claim Amount</strong></label>
                            <b-form-input v-model="text" class="mr-sm-2 col-md-8"></b-form-input>
                          </b-col> 
                        </b-row>
                    </b-form-group>
                    <b-form-group class="full-width mb-2">
                        <b-row>
                          <b-col col md="12" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="inline-form-input-name">Shares</label>
                            <b-form-select class="col-md-8" v-model="selected" :options="options"></b-form-select>
                          </b-col> 
                        </b-row>
                    </b-form-group>
                  </div>
                </div>
              </div>
            </b-card>
          </div>
        </section>
        <section class="content-form-section mt-2">
          <div class="content-form">
            <b-card class="text-center">
              <div class="row">
                <div class="col-lg-8 col-md-8 left-card-box">
                  <b-form class="fulw-width">
                      <b-form-group class="full-width mb-2">
                        <b-row>
                          <b-col col md="6" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="example-datepicker1">Begin Trans Date</label>
                            <b-form-datepicker id="example-datepicker1" v-model="value" class="col-md-8 text-left"></b-form-datepicker>
                          </b-col>
                        </b-row>
                      </b-form-group>
                      <b-form-group class="full-width mb-2">
                        <b-row>
                          <b-col col md="6" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="example-datepicker2">End Trans Date</label>
                            <b-form-datepicker id="example-datepicker2" v-model="value" class="col-md-8 text-left"></b-form-datepicker>
                          </b-col>
                        </b-row>
                      </b-form-group>
                      <b-form-group class="full-width mb-2">
                        <b-row class="full-box">
                          <b-col col md="6" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="example-datepicker3">Reported Date</label>
                            <b-form-datepicker id="example-datepicker3" v-model="value" class="col-md-8 text-left"></b-form-datepicker>
                          </b-col>  
                        </b-row>
                      </b-form-group>
                      <b-form-group class="full-width mb-2">
                        <b-row class="full-box">
                          <b-col col md="12" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-2" for="inline-form-input-name">Institution Name</label>
                            <b-form-input v-model="text" class="mr-sm-2 col-md-10"></b-form-input>
                          </b-col>  
                        </b-row>
                      </b-form-group>
                      <b-form-group class="full-width mb-2">
                        <b-row class="full-box">
                          <b-col col md="12" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-2" for="inline-form-input-name">Address</label>
                            <b-form-input v-model="text" class="mr-sm-2 col-md-10"></b-form-input>
                          </b-col>  
                        </b-row>
                      </b-form-group>
                      <b-form-group class="full-width mb-2">
                        <b-row>
                          <b-col col md="6" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="inline-form-input-name">City</label>
                            <b-form-input v-model="text" class="mr-sm-2 col-md-8"></b-form-input>
                          </b-col>
                          <b-col col md="3" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="inline-form-input-name">State</label>
                            <b-form-input v-model="text" class="col-md-8"></b-form-input>
                          </b-col>
                          <b-col col md="3" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4 p_all_0" for="inline-form-input-name">Zip Code</label>
                            <b-form-input v-model="text" class="col-md-8"></b-form-input>
                          </b-col>
                        </b-row>
                      </b-form-group>
                      <b-form-group class="full-width mb-2">
                        <b-row>
                          <b-col col md="6" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="example-datepicker4">Added Date</label>
                            <b-form-datepicker id="example-datepicker4" v-model="value" class="col-md-8 text-left"></b-form-datepicker>
                          </b-col>
                        </b-row>
                      </b-form-group>
                      <b-form-group class="full-width mb-2">
                        <b-row>
                          <b-col col md="6" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="example-datepicker5">Updated Date</label>
                            <b-form-datepicker id="example-datepicker5" v-model="value" class="col-md-8 text-left"></b-form-datepicker>
                          </b-col>
                        </b-row>
                      </b-form-group>
                      <b-form-group class="full-width mb-2">
                        <b-row>
                          <b-col col md="6" class="d-flex align-items-center inline-form-input-label">
                            <label class="input-label col-md-4" for="example-datepicker6"><strong>Most Recent Claim</strong></label>
                            <b-form-datepicker id="example-datepicker6" v-model="value" class="col-md-8 text-left"></b-form-datepicker>
                          </b-col>
                        </b-row>
                      </b-form-group>
                  </b-form>
                </div>
                <div class="col-lg-4 col-md-4">
                  <div class="inner-highlight-column text-left">
                      <h2>Note</h2>
                      <p>Lorem ipsum dolor sit amet, sapien etiam, nunc amet dolor ac odio mauris justo. Luctus arcu, urna praesent at id quisque ac. Arcu es massa vestibulum malesuada, integer vivamus elit eu mauris eus, cum eros quis aliquam wisi. Nulla wisi laoreet suspendisse integer vivamus elit eu mauris hendrerit facilisi, mi mattis pariatur aliquam pharetra eget.</p>
                      <p>Lorem ipsum dolor sit amet, sapien etiam, nunc amet dolor ac odio mauris justo. Luctus arcu, urna praesent at id quisque ac. Arcu es massa vestibulum malesuada, integer vivamus elit eu mauris eus, cum eros quis aliquam wisi. Nulla wisi laoreet suspendisse integer vivamus elit eu mauris hendrerit facilisi, mi mattis pariatur aliquam pharetra eget.</p>
                  </div>
                </div>
              </div>
            </b-card>
          </div>
        </section>
        <section class="content-form-section mt-2">
          <div class="content-form">
            <b-card class="text-center">
              <b-button variant="primary" class="purple-button">UPDATE</b-button>
            </b-card>
          </div>
        </section>
        <section class="content-form-section mt-2">
          <div class="content-form">
            <b-card title="Other Property" class="">
              <b-table-simple class="search-table" hover small caption-top responsive>
                  <b-thead head-variant="dark">
                    <b-tr>
                      <b-th>PROPERTY ID</b-th>
                      <b-th>PROPERTY TYPE</b-th>
                      <b-th>CLAIM AMOUNT</b-th>
                      <b-th>&nbsp;</b-th>
                    </b-tr>
                    <b-tr>
                      <b-td>123456</b-td>
                      <b-td>AC04 - Christmas Club Acct</b-td>
                      <b-td>$5,968.55</b-td>
                      <b-td>&nbsp;</b-td>
                    </b-tr>
                    <b-tr>
                      <b-td>246810</b-td>
                      <b-td>SC08 - Undelivered Stock</b-td>
                      <b-td>$8,000.00</b-td>
                      <b-td>&nbsp;</b-td>
                    </b-tr>
                    <b-tr>
                      <b-td>&nbsp;</b-td>
                      <b-td>&nbsp;</b-td>
                      <b-td>&nbsp;</b-td>
                      <b-td>&nbsp;</b-td>
                    </b-tr>
                    <b-tr>
                      <b-td>&nbsp;</b-td>
                      <b-td>&nbsp;</b-td>
                      <b-td>&nbsp;</b-td>
                      <b-td>&nbsp;</b-td>
                    </b-tr>
                    <b-tr>
                      <b-td>&nbsp;</b-td>
                      <b-td>&nbsp;</b-td>
                      <b-td>&nbsp;</b-td>
                      <b-td>&nbsp;</b-td>
                    </b-tr>
                  </b-thead>
              </b-table-simple>
            </b-card>
          </div>
        </section>
        <div class="search-form-section mt-4">
            <b-row>
                <b-col col lg="8">1 of 3</b-col>
                <b-col col lg="4">1 of 3</b-col>
            </b-row>
        </div>

    </div>
</template>

<script>
import { BCard, BNavForm, BCardText, BNavbar, BNavbarBrand, BLink, BFormGroup, BFormInput, BFormSelect, BDropdown, BDropdownItem, BRow, BCol, BButton, BSpinner, BFormFile, BForm, BFormDatepicker, BTableSimple, BThead, BTbody, BTr, BTd, BTh, BNavbarNav} from 'bootstrap-vue'

export default {
  components: {
    BCard,
    BNavbarBrand,
    BNavbar,
    BCardText,
    BNavForm,
    BLink,
    BFormGroup,
    BFormInput,
    BFormSelect,
    BDropdown,
    BDropdownItem,
    BRow,
    BCol,
    BButton,
    BSpinner,
    BFormFile,
    BForm,
    BFormDatepicker,
    BTableSimple, 
    BThead, 
    BTbody, 
    BTr, 
    BTd,
    BTh,
    BNavbarNav
  },
  data() {
      return {
        selected: null,
        options: [
          { value: null, text: 'Company Name' },
          { value: 'a', text: 'Property Type' },
          { value: 'b', text: 'Property ID' },
          { value: 'C', text: 'Schedule' },
          { value: 'D', text: 'Status' },
          { value: 'E', text: 'Date Found' },
        ]
      }
    }
}
</script>

<style>

</style>
