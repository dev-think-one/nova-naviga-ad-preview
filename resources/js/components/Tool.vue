<template>
    <div>
        <div class="mb-6 flex justify-between items-center">
            <Heading class="">
                Paginated lists
            </Heading>
            <a
                class="link-default"
                href="https://fin.navigahub.com/ElanWebPlatform/FIN/swagger/ui/index"
                target="_blank"
            >Documentation  <Icon type="external-link" width="20" height="20" /></a>
        </div>
        <div>
            <div class="mb-4">
                <SelectControl
                    v-model:selected="selectedListEndpoint"
                    class="w-full block"
                    :options="endpoints"
                >
                    <option
                        value=""
                        disabled
                        selected
                    >
                        {{ __('Paginated lists') }}
                    </option>
                </SelectControl>
            </div>
            <div class="mb-4">
                <label
                    class="font-bold"
                    for="queryPaginated"
                >
                    {{ __('Query params:') }}
                </label>
                <textarea
                    id="queryPaginated"
                    v-model="queryListEndpoint"
                    class="block w-full form-control form-input form-input-bordered py-3 h-auto"
                    :placeholder="'Key:Value\nKey2:Value2'"
                />
            </div>
            <div class="mb-2">
                <DefaultButton
                    @click="paginatedRequest(1)"
                >
                    {{ __('Request') }}
                </DefaultButton>
            </div>
        </div>
        <div v-if="listResponse.data && listResponse.meta">
            <div class="mt-4">
                <div
                    v-for="(entity, index) in listResponse.data"
                    :key="index"
                    class="mb-2 border p-2"
                >
                    <pre>{{ JSON.stringify(entity, null, 2) }}</pre>
                </div>
            </div>
            <div class="flex flex-wrap mt-4">
                <div class="w-full mb-4">
                    Showing {{
                        listResponse.meta.currentPage > 0 ? (((listResponse.meta.currentPage - 1) * 2) - 1) : 0
                    }} -
                    {{
                        listResponse.meta.currentPage > 0 ? (((listResponse.meta.currentPage - 1) * 2) - 1 + listResponse.meta.countEntities) : 0
                    }} items from
                    {{ listResponse.meta.totalEntities }}
                </div>
                <div
                    v-for="index in listResponse.meta.totalPages"
                    :key="index"
                    class="p-1 border m-1 cursor-pointer"
                    :class="{'bg-red-500 text-white': listResponse.meta.currentPage == index}"
                    @click="paginatedRequest(index)"
                >
                    {{ index }}
                </div>
            </div>
        </div>
        <div class="py-4">
            <hr>
            <hr>
            <hr>
        </div>
        <Heading class="mb-6">
            Direct request
        </Heading>
        <div>
            <div class="mb-4">
                <input
                    v-model="selectedDirectEndpoint"
                    class="w-full form-control form-input form-input-bordered"
                    type="text"
                    placeholder="campaigns/123123/lines"
                >
            </div>
            <div class="mb-4">
                <label
                    class="font-bold"
                    for="queryDirect"
                >
                    {{ __('Query params:') }}
                </label>
                <textarea
                    id="queryDirect"
                    v-model="queryDirectEndpoint"
                    class="block w-full form-control form-input form-input-bordered py-3 h-auto"
                    :placeholder="'Key:Value\nKey2:Value2'"
                />
            </div>
            <div class="mb-2">
                <DefaultButton
                    @click="directRequest()"
                >
                    {{ __('Request') }}
                </DefaultButton>
            </div>
        </div>
        <div v-if="directResponse">
            <pre>{{ JSON.stringify(directResponse, null, 2) }}</pre>
        </div>
    </div>
</template>

<script>

export default {
    metaInfo() {
        return {
            title: 'NavigaAdPreview',
        };
    },
    data() {
        return {
            loading: false,
            selectedListEndpoint: 'ad/adtypes',
            queryListEndpoint: '',
            listResponse: {},
            endpoints: [
                {label: this.__('campaigns'), value: 'campaigns'},
                {label: this.__('ad/adtypes'), value: 'ad/adtypes'},
                {label: this.__('book/ordertypes'), value: 'book/ordertypes'},
                {label: this.__('book/orders'), value: 'book/orders'},
                {label: this.__('accounting/creditcontrollers'), value: 'accounting/creditcontrollers'},
                {label: this.__('ad/audiencecodes'), value: 'ad/audiencecodes'},
                {label: this.__('general/banks'), value: 'general/banks'},
                {label: this.__('general/businessmodules'), value: 'general/businessmodules'},
                {label: this.__('/general/clienttypes'), value: '/general/clienttypes'},
                {label: this.__('/ad/colors'), value: '/ad/colors'},
                {label: this.__('crm/compNewsletters'), value: 'crm/compNewsletters'},
                {label: this.__('crm/compsubscriptions'), value: 'crm/compsubscriptions'},
                {label: this.__('crm/compsubslist'), value: 'crm/compsubslist'},
                {label: this.__('general/companies'), value: 'general/companies'},
                {label: this.__('accounting/payments'), value: 'accounting/payments'},
                {label: this.__('ad/sizes'), value: 'ad/sizes'},
                {label: this.__('general/status'), value: 'general/status'},
                {label: this.__('accounting/products'), value: 'accounting/products'},
            ],
            selectedDirectEndpoint: '',
            queryDirectEndpoint: '',
            directResponse: '',
        };
    },
    mounted() {
        //
    },
    methods: {
        paginatedRequest(page = 1) {
            this.loading = true;
            Nova.request()
                .post('/nova-vendor/nova-naviga-ad-preview/list-request', {
                    endpoint: this.selectedListEndpoint,
                    query: this.queryListEndpoint,
                    page: page || 1,
                })
                .then(({data}) => {
                    this.listResponse = data;
                })
                .catch((error) => {
                    Nova.error(error.message);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        directRequest() {
            this.loading = true;
            Nova.request()
                .post('/nova-vendor/nova-naviga-ad-preview/direct-request', {
                    endpoint: this.selectedDirectEndpoint,
                    query: this.queryDirectEndpoint,
                })
                .then(({data}) => {
                    this.directResponse = data.data;
                })
                .catch((error) => {
                    Nova.error(error.message);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
    },
};
</script>
