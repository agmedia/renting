<template>
    <div class="col-md-11">

        <h2 class="content-heading">{{ lang.unosinfo }}</h2>

        <div class="form-group row items-push">
            <div class=" col-md-12 ">
                <div class="bg-gray-light text-gray-darker p-3 pt-0 pb-0">
                    <div class="row ">
                        <div class="col-md-8 mt-3">
                            <p>{{ lang.odaberiteinfo }}<br>
                                <small>{{ lang.odaberiteinfotext }}</small>
                            </p>
                        </div>
                        <div class="col-md-4 mt-4">
                            <div class="input-group">
                                <select class="js-select2 form-control" id="favorite-select" :data-placeholder="lang.select">
                                    <option></option>
                                    <option v-for="(favorite, index) in favorites_list" :value="JSON.stringify(favorite)">{{ favorite.title[current_language] }}</option>
                                </select>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-alt-success" @click="selectFavorite()"><i class="fas fa-save"></i></button>
                                    <button type="button" class="btn btn-alt-secondary" @click="removeSelected('favorite')"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="dm-post-edit-title" class="w-100" >{{ lang.titleinfo }} <span class="text-danger">*</span>
                    <ul v-for="language in language_list" class="nav nav-pills float-right">
                        <li :class="{ active: language.code == current_language }">
                            <button type="button" class="btn btn-sm btn-outline-secondary ml-2" :class="{ active: language.code == current_language }" @click="current_language = language.code">
                                <img :src="base_path + 'media/flags/' + language.code + '.png'">
                            </button>
                        </li>
                    </ul>
                </label>

                <div v-for="language in language_list" v-if="language.code == current_language">
                    <input type="text" class="form-control" v-model="added_detail.title[language.code]" :placeholder="language.code" value="">
                    <span class="text-danger font-italic" v-if="title_error">{{ lang.nazivapartmana_error }}</span>
                </div>
            </div>
            <div class="col-md-4 mt-2">
                <label for="dm-post-edit-title">{{ lang.value }}</label>
                <input type="text" class="form-control" v-model="added_detail.value">
            </div>
            <div class="col-md-2 mt-2">
                <label for="dm-post-edit-title">{{ lang.size }} <span class="text-danger">*</span></label>
                <select class="js-select2 form-control" id="size-select" style="width: 100%;" :data-placeholder="lang.select">
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                </select>
                <span class="text-danger font-italic" v-if="group_error">{{ lang.nazivapartmana_error }}</span>
            </div>
            <div class="col-md-6">
                <label for="dm-post-edit-title">{{ lang.kratkiopisinfo }}</label>
                <div v-for="language in language_list" v-if="language.code == current_language">
                    <textarea class="form-control" v-model="added_detail.description[language.code]" :placeholder="language.code" rows="4">{{ language.code }}</textarea>
                </div>
            </div>
            <div class="col-md-6 mt-0">
                <div class="row">
                    <div class="col-md-6">
                        <label for="dm-post-edit-title">{{ lang.ikona }}</label>
                        <div class="input-group">
                            <select class="js-select2 form-control" id="icon-select" :data-placeholder="lang.odaberiteikonu">
                                <option></option>
                                <option value="1">Ikona bazen</option>
                                <option value="2">Ikona parking</option>
                                <option value="3">Ikona roštilj</option>
                            </select>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-alt-secondary" @click="removeSelected('icon')"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="dm-post-edit-title">{{ lang.galerijainfo }}</label>
                        <div class="input-group">
                            <select class="js-select2 form-control" id="gallery-select" :data-placeholder="lang.select">
                                <option></option>
                                <option v-for="(gallery, index) in gallery_list" :value="gallery.id">{{ gallery.title }}</option>
                            </select>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-alt-secondary" @click="removeSelected('gallery')"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 mt-4 pt-2">
                        <div class="custom-control custom-switch custom-control-info block-options-item ml-2">
                            <input type="checkbox" class="custom-control-input" id="favorite" v-model="added_detail.favorite">
                            <label class="custom-control-label" style="padding-top: 2px;" for="favorite">{{ lang.btnfavoriti }}</label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-4">
                        <button type="button" class="btn btn-success btn-block my-2" @click="saveItemToList">
                            <i class="fas fa-save mr-1"></i> Add to list
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="content-heading">{{ lang.listaunesenihnaslov }}</h2>

        <div class="form-group row items-push">
            <div class="col-md-12">
                <table class="table table-vcenter">
                    <thead>
                    <tr>
<!--                        <th class="text-center" style="width: 50px;">#</th>-->
                        <th>{{ lang.titleinfo }}</th>
                        <th class="d-none d-sm-table-cell" style="width: 25%;">{{ lang.value }}</th>
                        <th class="text-center" style="width: 100px;">{{ lang.action }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(detail, index) in added_details">
<!--                        <th class="text-center" scope="row">{{ index + 1 }}</th>-->
                        <td class="font-w600">
                            <a href="be_pages_generic_profile.html">{{ detail.title[current_language] }}</a>
                            <p class="small text-gray-dark mb-0" v-if="detail.description[current_language]">{{ detail.description[current_language] }}</p>
                        </td>
                        <td class="d-none d-sm-table-cell">{{ detail.value }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-primary js-tooltip-enabled" @click="editItem(index)">
                                    <i class="fa fa-pencil-alt"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Delete">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
<!--                    -->
<!--                    <tr v-for="(detail, index) in existing_details" style="background-color: #F5F5F5;">
                        <th class="text-center" scope="row">{{ detail.id }}</th>
                        <td class="font-w600">
                            <a href="be_pages_generic_profile.html">{{ detail.title[current_language] }}</a>
                            <p class="small text-gray-dark mb-0" v-if="detail.description[current_language]">{{ detail.description[current_language] }}</p>
                        </td>
                        <td class="d-none d-sm-table-cell">{{ detail.value }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-primary js-tooltip-enabled" @click="editItem(index)">
                                    <i class="fa fa-pencil-alt"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger js-tooltip-enabled" data-toggle="tooltip" title="" data-original-title="Delete">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>-->
                    </tbody>
                </table>
            </div>
        </div>

        <input type="hidden" name="added_details" :value="JSON.stringify(added_details)">
    </div>
</template>

<script>
    export default {
        props: {
            details: {
                type: String,
                required: false,
                default: null
            },
            favorites: {
                type: String,
                required: false,
                default: null
            },
            galleries: {
                type: String,
                required: false,
                default: null
            },
            languages: {
                type: String,
                required: true,
                default: ''
            },
            locale: {
                type: String,
                required: true,
                default: 'en'
            }
        },
        //
        data() {
            return {
                base_path: window.location.origin + '/',
                existing_details: JSON.parse(this.details),
                added_details: [],
                added_detail: {
                    title: {},
                    value: '',
                    group: 'S',
                    description: {},
                    icon: 0,
                    gallery_id: 0,
                    favorite: false
                },
                lang: window.trans,
                language_list: JSON.parse(this.languages),
                gallery_list: JSON.parse(this.galleries),
                favorites_list: JSON.parse(this.favorites),
                current_language: this.locale,
                selected_gallery: null,
                selected_favorite: null,
                selected_group: null,
                view_input: false,
                field_value: 0,
                title_error: false,
                group_error: false,
                edit_index: null,
            }
        },
        //
        mounted() {
            //this.resetDetail();

            this.setExistingDetails();
        },
        //
        methods: {

            setExistingDetails() {
                this.added_details = this.existing_details;
            },

            /**
             *
             */
            saveItemToList() {
                if (this.formHasErrors()) {
                    return;
                }

                if (this.edit_index) {
                    let index = this.edit_index - 1;

                    this.added_details[index].group = $('#size-select').val();
                    this.added_details[index].icon = $('#icon-select').val();
                    this.added_details[index].gallery_id = $('#gallery-select').val();
                    this.added_details[index].favorite = this.added_detail.favorite;
                    this.added_details[index].value = this.added_detail.value;

                    this.language_list.forEach((language) => {
                        this.added_details[index].title[language.code] = this.added_detail.title[language.code];
                        this.added_details[index].description[language.code] = this.added_detail.description[language.code];
                    });

                } else {
                    this.added_detail.group = $('#size-select').val();
                    this.added_detail.icon = $('#icon-select').val();
                    this.added_detail.gallery_id = $('#gallery-select').val();

                    this.added_details.push(this.added_detail);
                }

                this.resetDetail();
            },

            /**
             *
             * @param index
             */
            editItem(index) {
                let item = this.added_details[index];
                this.edit_index = index + 1;

                this.fillFormDetail(item);
            },

            /**
             *
             */
            selectFavorite() {
                let favorite = JSON.parse($('#favorite-select').val());

                this.fillFormDetail(favorite);
            },

            /**
             *
             * @param item
             */
            fillFormDetail(item) {
                this.added_detail.value = item.value;
                this.added_detail.favorite = item.favorite;
                this.added_detail.group = $('#size-select').val(item.group).trigger('change');
                this.added_detail.icon = $('#icon-select').val(item.icon).trigger('change');
                this.added_detail.gallery_id = $('#gallery-select').val(item.gallery_id).trigger('change');

                this.language_list.forEach((language) => {
                    this.added_detail.title[language.code] = item.title[language.code];
                    this.added_detail.description[language.code] = item.description[language.code];
                });
            },

            /**
             *
             * @return {boolean}
             */
            formHasErrors() {
                this.title_error = false;
                this.group_error = false;

                this.language_list.forEach((language) => {
                    if (this.added_detail.title[language.code] === undefined) {
                        this.title_error = true;
                    }
                });

                if (this.added_detail.group == '') {
                    this.group_error = true;
                }

                if (this.title_error || this.group_error) {
                    return true;
                }

                return false;
            },

            /**
             *
             * @param target
             */
            removeSelected(target) {
                $('#' + target + '-select').val(null).trigger('change');

                if (target === 'favorite') {
                    this.resetDetail();
                }
            },

            /**
             *
             */
            resetDetail() {
                this.edit_index = null;

                this.added_detail = {
                    title: {},
                    value: '',
                    group: 'S',
                    description: {},
                    icon: 0,
                    gallery_id: 0,
                    favorite: false
                }

                this.removeSelected('icon');
                this.removeSelected('gallery');
            },

        }
    };
</script>
<style>

</style>
