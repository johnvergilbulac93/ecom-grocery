<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="menu-custom">
                    <div class="menu-header">
                        <i class="fas fa-cog text-orange fa-lg"></i> SET-UP
                    </div>
                    <hr />
                    <ul class="mt-1">
                        <li class="custom-item">
                            <router-link
                                :to="{
                                    name: 'business_rule',
                                    params: { id: $root.userType }
                                }"
                            >
                                <span>Business Rules </span>
                            </router-link>
                        </li>
                        <li class="custom-item">
                            <router-link
                                :to="{
                                    name: 'bu_time',
                                    params: { id: $root.userType }
                                }"
                            >
                                <span>Store Time</span>
                            </router-link>
                        </li>
                        <li class="custom-item">
                            <router-link
                                :to="{
                                    name: 'tenant',
                                    params: { id: $root.userType }
                                }"
                            >
                                <span>Tenants</span>
                            </router-link>
                        </li>
                        <li class="custom-item">
                            <router-link
                                :to="{
                                    name: 'delivery_charges',
                                    params: { id: $root.userType }
                                }"
                            >
                                <span>Delivery Charges</span>
                            </router-link>
                        </li>
                        <li class="custom-item">
                            <router-link
                                :to="{
                                    name: 'minimum_delivery',
                                    params: { id: $root.userType }
                                }"
                            >
                                <span class="capitalize"
                                    >Minimum Order Delivery</span
                                >
                            </router-link>
                        </li>
                        <li class="custom-item">
                            <router-link
                                :to="{
                                    name: 'users',
                                    params: { id: $root.userType }
                                }"
                            >
                                <span>Manage Users</span>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-sm-6">
                <div class="menu-custom">
                    <div class="menu-header">
                        <i class="fas fa-shopping-cart text-orange fa-lg"></i>
                        ITEM
                    </div>
                    <hr />
                    <ul class="mt-1">
                        <li class="custom-item">
                            <router-link
                                :to="{
                                    name: 'central_item',
                                    params: { id: $root.userType }
                                }"
                            >
                                <span>Item Masterfile</span>
                            </router-link>
                        </li>
                        <li class="custom-item">
                            <router-link
                                :to="{
                                    name: 'disable_uom',
                                    params: { id: $root.userType }
                                }"
                            >
                                <span>Disabled Item Unit of Measure(UOM)</span>
                            </router-link>
                        </li>
                        <li class="custom-item">
                            <router-link
                                :to="{
                                    name: 'enable_uom',
                                    params: { id: $root.userType }
                                }"
                            >
                                <span>Enabled Item Unit of Measure(UOM)</span>
                            </router-link>
                        </li>
                        <li class="custom-item">
                            <router-link
                                :to="{
                                    name: 'count',
                                    params: { id: $root.userType }
                                }"
                            >
                                <span>Available Item Count per Store</span>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-sm-6">
                <div class="menu-custom">
                    <div class="menu-header">
                        <i
                            class="fas fa-cloud-upload-alt text-orange fa-lg"
                        ></i>
                        <span>UPLOADING</span>
                    </div>
                    <hr />
                    <ul class="mt-1">
                        <li class="custom-item">
                            <router-link
                                :to="{
                                    name: 'uploading',
                                    params: { id: $root.userType }
                                }"
                            >
                                <span>Upload New Item and New Price</span>
                            </router-link>
                        </li>
                        <li class="custom-item">
                            <router-link
                                :to="{
                                    name: 'setting',
                                    params: { id: $root.userType }
                                }"
                            >
                                <span>Upload Image filename and Category</span>
                            </router-link>
                        </li>
                        <li class="custom-item">
                            <router-link
                                :to="{
                                    name: 'multiple',
                                    params: { id: $root.userType }
                                }"
                            >
                                <span>Upload Multiple Images</span>
                            </router-link>
                        </li>

                        <li class="custom-item">
                            <router-link
                                :to="{
                                    name: 'description',
                                    params: { id: $root.userType }
                                }"
                            >
                                <span>Update Item Description</span>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-sm-6">
                <div class="menu-custom">
                    <div class="menu-header">
                        <i class="fas fa-list-alt text-orange fa-lg"></i>
                        <span>REPORTS</span>
                    </div>
                    <hr />
                    <ul class="mt-1">
                        <li class="custom-item">
                            <router-link
                                :to="{
                                    name: 'report_item',
                                    params: { id: $root.userType }
                                }"
                            >
                                <span>Item Report</span>
                            </router-link>
                        </li>
                        <li class="custom-item">
                            <router-link
                                :to="{
                                    name: 'liquidition',
                                    params: { id: $root.userType }
                                }"
                            >
                                <span>Liquidation Report</span>
                            </router-link>
                        </li>
                        <li class="custom-item">
                            <router-link
                                :to="{
                                    name: 'accountability',
                                    params: { id: $root.userType }
                                }"
                            >
                                <span>Accountability Report</span>
                            </router-link>
                        </li>
                        <li class="custom-item">
                            <router-link
                                :to="{
                                    name: 'transaction',
                                    params: { id: $root.userType }
                                }"
                            >
                                <span>Total Order Report - REMITTED </span>
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {};
    }
};
</script>
