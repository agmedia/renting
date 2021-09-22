<aside class="col-lg-4">
    <!-- Sidebar-->
    <div class="offcanvas offcanvas-collapse bg-white w-100 rounded-3 shadow-lg py-1" id="shop-sidebar" style="max-width: 22rem;">
        <div class="offcanvas-cap align-items-center shadow-sm">
            <h2 class="h5 mb-0">Filtriraj</h2>
            <button class="btn-close ms-auto" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body py-grid-gutter px-lg-grid-gutter">
            <!-- Categories-->
            @if ($categories)
                <div class="widget widget-categories mb-4 pb-4 border-bottom">
                    @if (! $subcategory)
                        <h3 class="widget-title">Kategorije</h3>
                    @else
                        <h3 class="widget-title">Podkategorije</h3>
                    @endif
                    <div class="accordion mt-n1" id="shop-categories">
                        @foreach ($categories as $category)
                            <div class="accordion-item @if( ! $loop->last) border-bottom @endif">
                                @if ($category->subcategories->count())
                                    <h3 class="accordion-header">
                                        <a href="{{ route('catalog.route', ['group' => \Illuminate\Support\Str::lower($category->group), 'cat' => $category]) }}" class="accordion-button py-2 none collapsed" role="link">
                                            {{ $category->title }} <span class="badge bg-secondary ms-2 position-absolute end-0">{{ $category->products_count }}</span>
                                        </a>
                                    </h3>
                                @else

                                    @if ($category->parent()->first())
                                        <h3 class="accordion-header">
                                            <a href="{{ route('catalog.route', ['group' => \Illuminate\Support\Str::lower($category->group), 'cat' => $category->parent()->first(), 'subcat' => $category]) }}" class="accordion-button py-2 none collapsed" role="link">
                                                {{ $category->title }} <span class="badge bg-secondary ms-2 position-absolute end-0">{{ $category->products_count }}</span>
                                            </a>
                                        </h3>
                                    @else
                                        <h3 class="accordion-header">
                                            <a href="{{ route('catalog.route', ['group' => \Illuminate\Support\Str::lower($category->group), 'cat' => $category]) }}" class="accordion-button py-2 none collapsed" role="link">
                                                {{ $category->title }} <span class="badge bg-secondary ms-2 position-absolute end-0">{{ $category->products_count }}</span>
                                            </a>
                                        </h3>
                                    @endif

                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Price range-->
            <div class="widget mb-4 pb-4 border-bottom">
                <h3 class="widget-title">Godina izdanja</h3>
                <div >
<!--                    <div class="range-slider-ui"></div>-->
                    <div class="d-flex pb-1">
                        <div class="w-50 pe-2 me-2">
                            <div class="input-group input-group-sm">
                                <input class="form-control range-slider-value-min" placeholder="Od" type="text" wire:model="start">
                                <span class="input-group-text">g</span>
                            </div>
                        </div>
                        <div class="w-50 ps-2">
                            <div class="input-group input-group-sm">
                                <input class="form-control range-slider-value-max" placeholder="Do" type="text" wire:model="end">
                                <span class="input-group-text">g</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter by Brand-->
            @if ($authors)
                <div class="widget widget-filter mb-4 pb-4 border-bottom">
                    <h3 class="widget-title">Autor</h3>
                    <div class="input-group input-group-sm mb-2 autocomplete">
                        <input id="myInput" class=" form-control rounded-end pe-5" type="text"   placeholder="Pretraži autora"><i class="ci-search position-absolute top-50 end-0 translate-middle-y fs-sm me-3"></i>
                    </div>

                 <!--   <ul class="widget-list widget-filter-list list-unstyled pt-1" style="max-height: 11rem;" data-simplebar data-simplebar-auto-hide="false" wire:ignore>
                        @foreach ($authors as $aid => $author)
                            <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" wire:model="author.{{ $aid }}" value="{{ \Illuminate\Support\Str::slug($author['title']) }}" id="author_{{ $aid }}">
                                    <label class="form-check-label widget-filter-item-text" for="author_{{ $aid }}">{{ $author['title'] }}</label>
                                </div><span class="fs-xs text-muted">{{ $author['broj'] }}</span>
                            </li>
                        @endforeach
                    </ul> -->
                </div>
            @endif


            <!-- Filter by NAkladnik-->
            @if ($publishers)
                <div class="widget widget-filter mb-4 pb-4 border-bottom">
                    <h3 class="widget-title">Nakladnici</h3>
                    <div class="input-group input-group-sm mb-2">
                        <input class="widget-filter-search form-control rounded-end pe-5" type="text" placeholder="Pretraži nakladnika"><i class="ci-search position-absolute top-50 end-0 translate-middle-y fs-sm me-3"></i>
                    </div>
                    <ul class="widget-list widget-filter-list list-unstyled pt-1" style="max-height: 11rem;" data-simplebar data-simplebar-auto-hide="false">
                        @foreach ($publishers as $pid => $publisher)
                            <li class="widget-filter-item d-flex justify-content-between align-items-center mb-1">
                                <div class="form-check ">
                                    <input class="form-check-input" type="checkbox" wire:model="publisher.{{ $pid }}" value="{{ \Illuminate\Support\Str::slug($publisher['title']) }}" id="publisher_{{ $pid }}">
                                    <label class="form-check-label widget-filter-item-text" for="publisher_{{ $pid }}">{{ $publisher['title'] }}</label>
                                </div><span class="fs-xs text-muted">{{ $publisher['broj'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <button type="button" onclick="cleanURL();" class="btn btn-primary mt-4"><i class=" ci-trash"></i> Očisti sve</button>

        </div>
    </div>
</aside>

@push('js_after')
<style>


    /*the container must be positioned relative:*/
    .autocomplete {
        position: relative;

    }


    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        /*position the autocomplete items to be the same width as the container:*/
        top: 100%;
        left: 0;
        right: 0;
    }

    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d4;
        font-size:14px
    }

    /*when hovering an item:*/
    .autocomplete-items div:hover {
        background-color: #e9e9e9;
    }

    /*when navigating through the items using the arrow keys:*/
    .autocomplete-active {
        background-color: DodgerBlue !important;
        color: #ffffff;
    }
</style>


<script>
    $( document ).ready(function() {
    function autocomplete(inp, arr) {
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        var currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
            /*close any already open lists of autocompleted values*/
            closeAllLists();
            if (!val) { return false;}
            currentFocus = -1;
            /*create a DIV element that will contain the items (values):*/
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            /*append the DIV element as a child of the autocomplete container:*/
            this.parentNode.appendChild(a);
            /*for each item in the array...*/
            for (i = 0; i < arr.length; i++) {
                /*check if the item starts with the same letters as the text field value:*/
                if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    /*create a DIV element for each matching element:*/
                    b = document.createElement("DIV");
                    /*make the matching letters bold:*/
                    b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                    b.innerHTML += arr[i].substr(val.length);
                    /*insert a input field that will hold the current array item's value:*/
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                    /*execute a function when someone clicks on the item value (DIV element):*/
                    b.addEventListener("click", function(e) {
                        /*insert the value for the autocomplete text field:*/
                        inp.value = this.getElementsByTagName("input")[0].value;
                        /*close the list of autocompleted values,
                        (or any other open lists of autocompleted values:*/
                        closeAllLists();
                    });
                    a.appendChild(b);
                }
            }
        });
        /*execute a function presses a key on the keyboard:*/
        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                /*If the arrow DOWN key is pressed,
                increase the currentFocus variable:*/
                currentFocus++;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 38) { //up
                /*If the arrow UP key is pressed,
                decrease the currentFocus variable:*/
                currentFocus--;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 13) {
                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                e.preventDefault();
                if (currentFocus > -1) {
                    /*and simulate a click on the "active" item:*/
                    if (x) x[currentFocus].click();
                }
            }
        });
        function addActive(x) {
            /*a function to classify an item as "active":*/
            if (!x) return false;
            /*start by removing the "active" class on all items:*/
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            /*add class "autocomplete-active":*/
            x[currentFocus].classList.add("autocomplete-active");
        }
        function removeActive(x) {
            /*a function to remove the "active" class from all autocomplete items:*/
            for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
            }
        }
        function closeAllLists(elmnt) {
            /*close all autocomplete lists in the document,
            except the one passed as an argument:*/
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }
        /*execute a function when someone clicks in the document:*/
        document.addEventListener("click", function (e) {
            closeAllLists(e.target);
        });
    }

    /*An array containing all the country names in the world:*/
    var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];

    /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
    autocomplete(document.getElementById("myInput"), countries);
    });
</script>
@endpush
