<div>
    <div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="tc_aside">
        <!--begin::Brand-->
        <div class="brand flex-column-auto" id="tc_brand">
            <!--begin::Logo-->

            <a href="index.html" class="brand-logo">
                <img class="brand-image" style="height: 25px;" alt="Logo" src="{{asset('assets/images/misc/k.png')}}" />
                <span class="brand-text"><img style="height: 25px;" alt="Logo"
                        src="{{asset('assets/images/misc/logo.png')}}" /></span>

            </a>
            <!--end::Logo-->


        </div>
        <!--end::Brand-->
        <!--begin::Aside Menu-->
        <div class="aside-menu-wrapper flex-column-fluid overflow-auto h-100" id="tc_aside_menu_wrapper">
            <!--begin::Menu Container-->
            <div id="tc_aside_menu" class="aside-menu  mb-5" data-menu-vertical="1" data-menu-scroll="1"
                data-menu-dropdown-timeout="500">
                <!--begin::Menu Nav-->
              <div id="accordion">
                <ul class="nav flex-column">
                    <li class="nav-item active">
                        <a href="index.html" class="nav-link">
                            <span class="svg-icon nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                            </span>
                            <span class="nav-text">
                                Dashboard
                            </span>
                        </a>


                    </li>
                    <li class="nav-item">
                        <a  class="nav-link" data-toggle="collapse" href="javascript:void(0)" data-target="#media" role="button"
                        aria-expanded="false" aria-controls="media">


                            <span class="svg-icon nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-image">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                            </span>
                            <span class="nav-text">Media</span>
                            <i class="fas fa-chevron-right fa-rotate-90"></i>

                        </a>
                        <div class="collapse nav-collapse" id="media" data-parent="#accordion">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="media-manage.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Manage Media</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="media-detail.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Media Detail</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="media-setting.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>

                                        <span class="nav-text">Media Settings</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a  class="nav-link" data-toggle="collapse"  href="javascript:void(0)" data-target="#catalog" role="button"
                        aria-expanded="false" aria-controls="catalog">
                            <span class="svg-icon nav-icon">
                                <i class="fas fa-boxes font-size-h4"></i>
                            </span>
                            <span class="nav-text">Catalog</span>
                            <i class="fas fa-chevron-right fa-rotate-90"></i>
                        </a>
                        <div class="collapse nav-collapse" id="catalog" data-parent="#accordion">
                            <div id="accordion1">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a href="product-units-list.html" class="nav-link sub-nav-link">
                                            <span class="svg-icon nav-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                  </svg>
                                            </span>
                                            <span class="nav-text">Product Units</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="product-variation-list.html" class="nav-link sub-nav-link">
                                            <span class="svg-icon nav-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                  </svg>
                                            </span>
                                            <span class="nav-text">Product Variations</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="product-brands-list.html" class="nav-link sub-nav-link">
                                            <span class="svg-icon nav-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                  </svg>
                                            </span>
                                            <span class="nav-text">Product Brands</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="product-category-list.html" class="nav-link sub-nav-link">
                                            <span class="svg-icon nav-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                  </svg>
                                            </span>
                                            <span class="nav-text">Product Categories</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="product-review.html" class="nav-link sub-nav-link">
                                            <span class="svg-icon nav-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                  </svg>
                                            </span>
                                            <span class="nav-text">Product Review</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="product-barcode.html" class="nav-link sub-nav-link">
                                            <span class="svg-icon nav-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                  </svg>
                                            </span>
                                            <span class="nav-text">Product Bar code Label</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a  class="nav-link sub-nav-link" data-toggle="collapse" href="#catalogProduct" role="button"
                                        aria-expanded="false" aria-controls="catalogProduct">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                            <span class="nav-text">Products</span>
                                            <i class="fas fa-chevron-right fa-rotate-90"></i>
                                        </a>
                                        <div class="collapse nav-collapse" id="catalogProduct" data-parent="#accordion1">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a href="products.html" class="nav-link mini-sub-nav-link">

                                                        <span class="nav-text">List</span>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="add-product.html" class="nav-link mini-sub-nav-link" >

                                                        <span class="nav-text">Add Product</span>
                                                    </a>
                                                </li>


                                            </ul>
                                        </div>
                                    </li>

                                    <li class="nav-item">
                                        <a  class="nav-link sub-nav-link" data-toggle="collapse" href="#catalogStock" role="button"
                                        aria-expanded="false" aria-controls="catalogStock">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                            <span class="nav-text">Product Stock</span>
                                            <i class="fas fa-chevron-right fa-rotate-90"></i>
                                        </a>
                                        <div class="collapse nav-collapse" id="catalogStock" data-parent="#accordion1">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a href="stock-add.html" class="nav-link mini-sub-nav-link">
                                                        <span class="nav-text">Add Stock</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="stock-transfer.html" class="nav-link mini-sub-nav-link">
                                                         <span class="nav-text">Stock Transfer</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a  class="nav-link" data-toggle="collapse" href="#catalogPurchase" role="button"
                        aria-expanded="false" aria-controls="catalogPurchase">
                            <span class="svg-icon nav-icon">
                                <i class="fas fa-money-check-alt font-size-h4"></i>
                            </span>
                            <span class="nav-text">Purchase</span>
                            <i class="fas fa-chevron-right fa-rotate-90"></i>
                        </a>
                        <div class="collapse nav-collapse" id="catalogPurchase"  data-parent="#accordion">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="purchase-list.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">List</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="purchase-add.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Add Purchase</span>
                                    </a>
                                </li>


                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a  class="nav-link" data-toggle="collapse" href="#order" role="button"
                        aria-expanded="false" aria-controls="order">
                            <span class="svg-icon nav-icon">
                                <i class="fas fa-clipboard-check font-size-h4" ></i>
                            </span>
                            <span class="nav-text">Sell / Orders</span>
                            <i class="fas fa-chevron-right fa-rotate-90"></i>
                        </a>
                        <div class="collapse nav-collapse" id="order"  data-parent="#accordion">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="order-list.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">List</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="order-detail.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Order Detail</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="add-sale.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Add Sale</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="pos.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">POS</span>
                                    </a>
                                </li>


                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a  class="nav-link" data-toggle="collapse" href="#Quotations" role="button"
                        aria-expanded="false" aria-controls="Quotations">
                            <span class="svg-icon nav-icon">
                                <i class="fas fa-quote-right font-size-h4"></i>
                            </span>
                            <span class="nav-text">Quotations</span>
                            <i class="fas fa-chevron-right fa-rotate-90"></i>
                        </a>
                        <div class="collapse nav-collapse" id="Quotations"  data-parent="#accordion">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="quotations-list.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">All Quotations</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="quotations-add.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Add Quotation</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a  class="nav-link" data-toggle="collapse" href="#Returns" role="button"
                        aria-expanded="false" aria-controls="Returns">
                            <span class="svg-icon nav-icon">
                                <i class="fas fa-undo-alt font-size-h4"></i>
                            </span>
                            <span class="nav-text">Returns</span>
                            <i class="fas fa-chevron-right fa-rotate-90"></i>
                        </a>
                        <div class="collapse nav-collapse" id="Returns" data-parent="#accordion">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="sale-return.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Sale Returns</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="Return-add.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Add Returns</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="purchase-return.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Purchase Returns</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="purchase-return-add.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Add Return Purchase</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a  class="nav-link" data-toggle="collapse" href="#People" role="button"
                        aria-expanded="false" aria-controls="People">
                            <span class="svg-icon nav-icon">
                                <i class="fas fa-user-friends font-size-h4"></i>
                            </span>
                            <span class="nav-text">People</span>
                            <i class="fas fa-chevron-right fa-rotate-90"></i>
                        </a>
                        <div class="collapse nav-collapse" id="People" data-parent="#accordion">
                            <div id="accordion2">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link sub-nav-link" data-toggle="collapse" href="#admins" role="button" aria-expanded="false" aria-controls="catalogProduct">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                                              </svg>
                                        </span>
                                            <span class="nav-text">Admins</span>
                                            <i class="fas fa-chevron-right fa-rotate-90"></i>
                                        </a>
                                        <div class="collapse nav-collapse" id="admins" data-parent="#accordion1">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a href="admin-list.html" class="nav-link mini-sub-nav-link">

                                                        <span class="nav-text">List</span>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="roles-permission.html" class="nav-link mini-sub-nav-link">
                                                        <span class="nav-text">Roles/Permisssions</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>

                                    <li class="nav-item">
                                        <a href="billers-list.html" class="nav-link sub-nav-link">
                                            <span class="svg-icon nav-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                  </svg>
                                            </span>
                                            <span class="nav-text">Billers</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="supplier-list.html" class="nav-link sub-nav-link">
                                            <span class="svg-icon nav-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                  </svg>
                                            </span>
                                            <span class="nav-text">Supplier</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="customer-list.html" class="nav-link sub-nav-link">
                                            <span class="svg-icon nav-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                  </svg>
                                            </span>
                                            <span class="nav-text">Customer</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="customer-edit.html" class="nav-link sub-nav-link">
                                            <span class="svg-icon nav-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                  </svg>
                                            </span>
                                            <span class="nav-text">Customer Edit</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a  class="nav-link" data-toggle="collapse" href="#account" role="button"
                        aria-expanded="false" aria-controls="account">
                            <span class="svg-icon nav-icon">
                                <i class="fas fa-file-invoice-dollar font-size-h4"></i>
                            </span>
                            <span class="nav-text">Accounts</span>
                            <i class="fas fa-chevron-right fa-rotate-90"></i>
                        </a>
                        <div class="collapse nav-collapse" id="account" data-parent="#accordion">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="accounts-list.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">List</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="accounts-balance-sheet.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Balance Sheet</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="accounts-trial-balance.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Trial Balance</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="accounts-cashFlow.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Cash Flow</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="accounts-payment-report.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Payment Account Report</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a  class="nav-link" data-toggle="collapse" href="#expenses" role="button"
                        aria-expanded="false" aria-controls="expenses">
                            <span class="svg-icon nav-icon">
                                <i class="fas fa-money-bill font-size-h4"></i>
                            </span>
                            <span class="nav-text">Expenses</span>
                            <i class="fas fa-chevron-right fa-rotate-90"></i>
                        </a>
                        <div class="collapse nav-collapse" id="expenses" data-parent="#accordion">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="expenses-list.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">List</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="expenses-type.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Expense Type</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a  class="nav-link" data-toggle="collapse" href="#reports" role="button"
                        aria-expanded="false" aria-controls="reports">
                            <span class="svg-icon nav-icon">
                                <i class="fas fa-chart-line font-size-h4"></i>
                            </span>
                            <span class="nav-text">Reports</span>
                            <i class="fas fa-chevron-right fa-rotate-90"></i>
                        </a>
                        <div class="collapse nav-collapse" id="reports" data-parent="#accordion">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="profit-loss-report.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Profit / Loss</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="purchase-report.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Purchase Report</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="sale-report.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Sale Report</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="supplier-report.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Supplier Report</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="customer-report.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Customer Report</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="stock-report.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Stock Report</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="stock-adjustment-report.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Stock Adjustment Report</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="outOfStock-report.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Out of Stock Report</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="stock-alert-report.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Stock Alert Report</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="expense-report.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Expense Report</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a  class="nav-link" data-toggle="collapse" href="#setting" role="button"
                        aria-expanded="false" aria-controls="setting">
                            <span class="svg-icon nav-icon">
                                <i class="fas fa-cogs font-size-h4"></i>
                            </span>
                            <span class="nav-text">Settings</span>
                            <i class="fas fa-chevron-right fa-rotate-90"></i>
                        </a>
                        <div class="collapse nav-collapse" id="setting" data-parent="#accordion">
                            <div id="accordion3">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a  class="nav-link sub-nav-link" data-toggle="collapse" href="#settingB" role="button"
                                        aria-expanded="false" aria-controls="settingB">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                            <span class="nav-text">Bussiness Setting</span>
                                            <i class="fas fa-chevron-right fa-rotate-90"></i>
                                        </a>
                                        <div class="collapse nav-collapse" id="settingB" data-parent="#accordion3">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a href="bussiness-setting.html#general"  class="nav-link mini-sub-nav-link">

                                                        <span class="nav-text">General</span>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="bussiness-setting.html#pos" class="nav-link mini-sub-nav-link">

                                                        <span class="nav-text">POS</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="bussiness-setting.html#email" class="nav-link mini-sub-nav-link">

                                                        <span class="nav-text">Email SMTP Settings</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="bussiness-setting.html#sms" class="nav-link mini-sub-nav-link">

                                                        <span class="nav-text">SMS Setting</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="bussiness-setting.html#emailtemp" class="nav-link mini-sub-nav-link">

                                                        <span class="nav-text">Email Templates</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="bussiness-setting.html#notification" class="nav-link mini-sub-nav-link">

                                                        <span class="nav-text">Notifications Setting</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="bussiness-setting.html#invoice" class="nav-link mini-sub-nav-link">

                                                        <span class="nav-text">Inovice Setting</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="bussiness-setting.html#barcodes" class="nav-link mini-sub-nav-link">

                                                        <span class="nav-text">Bar Code Setting</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a  class="nav-link sub-nav-link" data-toggle="collapse" href="#settingW" role="button"
                                        aria-expanded="false" aria-controls="settingW">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                            <span class="nav-text">Website Settings</span>
                                            <i class="fas fa-chevron-right fa-rotate-90"></i>
                                        </a>
                                        <div class="collapse nav-collapse" id="settingW" data-parent="#accordion3">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a href="website-setting.html#general" class="nav-link mini-sub-nav-link">

                                                        <span class="nav-text">General</span>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="website-setting.html#themeColor" class="nav-link mini-sub-nav-link">

                                                        <span class="nav-text">Theming / Colors</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="website-setting.html#SEO" class="nav-link mini-sub-nav-link">

                                                        <span class="nav-text">SEO</span>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="website-setting.html#log-sign" class="nav-link mini-sub-nav-link">

                                                        <span class="nav-text">Login / SignUp</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="website-setting.html#slider" class="nav-link mini-sub-nav-link">

                                                        <span class="nav-text">Slider</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="Menu-bulider.html" class="nav-link mini-sub-nav-link">

                                                        <span class="nav-text">Menu Builder</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a  class="nav-link sub-nav-link"  data-toggle="collapse" href="#settingA" role="button"
                                        aria-expanded="false" aria-controls="settingA">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                            <span class="nav-text">App Settings</span>
                                            <i class="fas fa-chevron-right fa-rotate-90"></i>
                                        </a>
                                        <div class="collapse nav-collapse" id="settingA" data-parent="#accordion3">
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a href="app-setting.html#general" class="nav-link mini-sub-nav-link">

                                                        <span class="nav-text">General</span>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="app-setting.html#display" class="nav-link mini-sub-nav-link">

                                                        <span class="nav-text">Display In Menu/Sidebar</span>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="app-setting.html#notificationS" class="nav-link mini-sub-nav-link">

                                                        <span class="nav-text">Local Notification</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="app-setting.html#log-sign" class="nav-link mini-sub-nav-link">

                                                        <span class="nav-text">Login/Signup</span>
                                                    </a>
                                                </li>


                                            </ul>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a href="warehouse.html" class="nav-link sub-nav-link">
                                            <span class="svg-icon nav-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                  </svg>
                                            </span>
                                            <span class="nav-text">Warehouse</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="language.html" class="nav-link sub-nav-link">
                                            <span class="svg-icon nav-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                  </svg>
                                            </span>
                                            <span class="nav-text">Language</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="currency.html" class="nav-link sub-nav-link">
                                            <span class="svg-icon nav-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                  </svg>
                                            </span>
                                            <span class="nav-text">Currency</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="payment.html" class="nav-link sub-nav-link">
                                            <span class="svg-icon nav-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                  </svg>
                                            </span>
                                            <span class="nav-text">Payement Methods</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="shippingmethods.html" class="nav-link sub-nav-link">
                                            <span class="svg-icon nav-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                  </svg>
                                            </span>
                                            <span class="nav-text">Shipping Methods</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="Tax.html" class="nav-link sub-nav-link">
                                            <span class="svg-icon nav-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                  </svg>
                                            </span>
                                            <span class="nav-text">Tax Settings</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="coupons.html" class="nav-link sub-nav-link">
                                            <span class="svg-icon nav-icon d-flex justify-content-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                  </svg>
                                            </span>
                                            <span class="nav-text">Coupon Settings</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>



                    <li class="nav-header mt-3">
                        <span class="nav-text font-size-bold">UI Elements</span>
                        <span class="svg-icon nav-icon text-primary">
                            <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-three-dots"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                            </svg>
                        </span>
                    </li>

                    <li class="nav-item">
                        <a  class="nav-link" data-toggle="collapse" href="#components" role="button"
                        aria-expanded="false" aria-controls="components">
                            <span class="svg-icon nav-icon">
                                <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-check2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                  </svg>
                            </span>
                            <span class="nav-text">Components</span>
                            <i class="fas fa-chevron-right fa-rotate-90"></i>
                        </a>
                        <div class="collapse nav-collapse" id="components" data-parent="#accordion">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="buttons.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Buttons</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="modals.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Modals</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="alerts.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Alerts</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="tabs.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Tabs</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="Carousel.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Carousel</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="switcher.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Switcher</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item mb-5">
                        <a  class="nav-link" data-toggle="collapse" href="#basic-input" role="button"
                        aria-expanded="false" aria-controls="basic-input">
                            <span class="svg-icon nav-icon">
                                <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-check2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                  </svg>
                            </span>
                            <span class="nav-text">Forms</span>
                            <i class="fas fa-chevron-right fa-rotate-90"></i>
                        </a>
                        <div class="collapse nav-collapse" id="basic-input" data-parent="#accordion">
                            <ul class="nav flex-column">

                                <li class="nav-item">
                                    <a href="form-input.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Basic Input</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="form-select.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Select Input</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="form-radio.html" class="nav-link sub-nav-link" >
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Radio Input</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="form-checkbox.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">checkbox Input</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="form-textarea.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Textarea Input</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="form-editor.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Text Editor</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="datepicker.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Date & Time Picker </span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="form-validation.html" class="nav-link sub-nav-link">
                                        <span class="svg-icon nav-icon d-flex justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10px" height="10px" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                              </svg>
                                        </span>
                                        <span class="nav-text">Form Validation</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                </ul>
              </div>

                <!--end::Menu Nav-->
            </div>
            <!--end::Menu Container-->
        </div>
        <!--end::Aside Menu-->
    </div>
</div>
