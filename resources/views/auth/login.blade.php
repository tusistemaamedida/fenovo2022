@extends('layouts.app')


@section('content')

<div class="container-fluid h-100 bg-image" style="background-image: url(./assets/images/misc/bg-login1.png);">
    <div class="d-flex justify-content-center align-items-center h-100">
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-4">
                <div class="card card-custom gutter-b bg-white border-0 mb-0 p-5 login-card">
                    <div class="card-header align-items-center  justify-content-center border-0 h-100px flex-column">
                        <div class="card-title mb-0">
                            <h3 class="card-label font-weight-bold mb-0 text-body">
                                <img src="./assets/images/misc/logo.png" alt="logo">
                            </h3>

                        </div>
                        <h5 class="font-size-h5 mb-0 mt-3 text-dark">
                            Please login to your account.
                        </h5>

                    </div>
                    <div class="card-body p-0">
                        <form id="myform" class="pb-5 pt-5">
                            <div class="form-group  row">
                                <div class="col-lg-2 col-3 ">
                                    <label for="exampleInputEmail1" class="mb-0 text-dark">
                                        <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-person" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                          </svg>
                                    </label>
                                </div>
                                <div class="col-lg-10 col-9 pl-0">
                                    <input type="email" name="email" class="form-control bg-transparent text-dark border-0 p-0 h-20px font-size-h5" placeholder="example@mail.com" id="exampleInputEmail1" aria-describedby="emailHelp">

                                </div>

                            </div>
                            <div class="form-group row ">
                                <div class="col-lg-2 col-3 ">
                                    <label for="exampleInputPassword1" class="mb-0 text-dark">
                                        <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-lock" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M11.5 8h-7a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1zm-7-1a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-7zm0-3a3.5 3.5 0 1 1 7 0v3h-1V4a2.5 2.5 0 0 0-5 0v3h-1V4z"/>
                                          </svg>
                                    </label>
                                </div>
                                <div class="col-lg-10 col-9 pl-0">
                                    <input type="password" name="password" placeholder="......." class="form-control text-dark bg-transparent font-size-h4 border-0 p-0 h-20px" id="exampleInputPassword1">
                                </div>

                            </div>
                            <div class="form-group row align-items-center justify-content-between">
                                <div class="col-6">
                                    <div class="form-check pl-4">
                                        <input type="checkbox" class="form-check-input ml--4" id="exampleCheck1">
                                        <label class="form-check-label text-dark" for="exampleCheck1">Remember me</label>
                                    </div>
                                </div>

                                <div class="col-6 text-right">
                                    <a href="#">Forgot Password?</a>
                                </div>

                            </div>
                            <button type="button" class="btn btn-primary text-white font-weight-bold w-100 py-3" data-toggle="modal" data-target="#default">
                                Login
                              </button>
                              <!--Basic Modal -->
                              <div class="modal fade text-left" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h3 class="modal-title" id="myModalLabel1">Setting</h3>
                                      <button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-dismiss="modal" aria-label="Close">
                                        <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                                        </svg>
                                      </button>

                                    </div>
                                    <div class="modal-body text-center">
                                        <ul class="list-unstyled mb-3 font-size-h4">
                                            <li class="d-inline-block mr-3 mb-1">
                                              <fieldset>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="DigitalPhysical" id="PhysicalRadios1" value="Physical" onclick="checkedPoint()">
                                                    <label class="form-check-label" for="PhysicalRadios1">
                                                    Physical
                                                    </label>
                                                </div>
                                              </fieldset>
                                            </li>
                                            <li class="d-inline-block mr-3 mb-1">
                                              <fieldset>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="DigitalPhysical" id="DigitalRadio2" value="Digital" onclick="checkedPoint()">
                                                    <label class="form-check-label" for="DigitalRadio2">Digital</label>
                                                </div>
                                              </fieldset>
                                            </li>
                                          </ul>
                                          <div class="DigitalEnter" id="DigitalEnter" style="display: none;">
                                            <h3 class="text-dark font-size-h3 mb-3">
                                                Account
                                            </h3>
                                          <ul class="list-unstyled  mb-3 font-size-h4">
                                              <li class="d-inline-block mr-3 mb-1">
                                                <fieldset>
                                                  <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="AccountRadios" id="AccountRadios1" value="option1" checked>
                                                      <label class="form-check-label" for="AccountRadios1">
                                                      Yes
                                                      </label>
                                                  </div>
                                                </fieldset>
                                              </li>
                                              <li class="d-inline-block mr-3 mb-1">
                                                <fieldset>
                                                  <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="AccountRadios" id="AccountRadios2" value="option2">
                                                      <label class="form-check-label" for="AccountRadios2">No</label>
                                                  </div>
                                                </fieldset>
                                              </li>
                                            </ul>
                                        </div>
                                          <div class="inventryEnter" id="inventryEnter" style="display: none;">
                                              <h3 class="text-dark font-size-h3 mb-3">
                                                  Inventory
                                              </h3>
                                            <ul class="list-unstyled  mb-3 font-size-h4">
                                                <li class="d-inline-block mr-3 mb-1">
                                                  <fieldset>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="InventoryRadios" id="InventoryRadios1" value="yes" onclick="checkedPoint()">
                                                        <label class="form-check-label" for="InventoryRadios1">
                                                        Yes
                                                        </label>
                                                    </div>
                                                  </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-3 mb-1">
                                                  <fieldset>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="InventoryRadios" id="InventoryRadio2" value="no" onclick="checkedPoint()">
                                                        <label class="form-check-label" for="InventoryRadio2">No</label>
                                                    </div>
                                                  </fieldset>
                                                </li>
                                              </ul>
                                          </div>
                                          <div class="afterinventory" id="afterinventory"  style="display: none;">
                                            <ul class="list-unstyled mb-3 font-size-h4">
                                                <li class="d-inline-block mr-3 mb-1">
                                                  <fieldset>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="extendRadios" id="extendRadios1" value="option1" onclick="checkedPoint()">
                                                        <label class="form-check-label" for="extendRadios1">
                                                        Simple
                                                        </label>
                                                    </div>
                                                  </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-3 mb-1">
                                                  <fieldset>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="extendRadios" id="extendRadios2" value="option2" onclick="checkedPoint()">
                                                        <label class="form-check-label" for="extendRadios2">Advance</label>
                                                    </div>
                                                  </fieldset>
                                                </li>
                                              </ul>
                                          </div>
                                          <div class="afterinventorynext" id="afterinventorynext"  style="display: none;">
                                            <ul class="list-unstyled mb-0">
                                                <li class="d-inline-block mr-2 mb-1">
                                                  <fieldset>
                                                    <div class="checkbox">
                                                      <input type="checkbox" class="checkbox-input" id="checkbox1" checked="">
                                                      <label for="checkbox1">POS</label>
                                                    </div>
                                                  </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2 mb-1">
                                                  <fieldset>
                                                    <div class="checkbox">
                                                      <input type="checkbox" class="checkbox-input" id="checkbox2">
                                                      <label for="checkbox2">Account</label>
                                                    </div>
                                                  </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2 mb-1">
                                                    <fieldset>
                                                      <div class="checkbox">
                                                        <input type="checkbox" class="checkbox-input" id="checkbox3">
                                                        <label for="checkbox3">Purchasing</label>
                                                      </div>
                                                    </fieldset>
                                                  </li>
                                                  <li class="d-inline-block mr-2 mb-1">
                                                    <fieldset>
                                                      <div class="checkbox">
                                                        <input type="checkbox" class="checkbox-input" id="checkbox4">
                                                        <label for="checkbox4">Warehouse</label>
                                                      </div>
                                                    </fieldset>
                                                  </li>
                                                  <li class="d-inline-block mr-2 mb-1">
                                                    <fieldset>
                                                      <div class="checkbox">
                                                        <input type="checkbox" class="checkbox-input" id="checkbox5">
                                                        <label for="checkbox5">Simple</label>
                                                      </div>
                                                    </fieldset>
                                                  </li>
                                              </ul>
                                          </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-light" data-dismiss="modal">

                                        <span class="">Close</span>
                                      </button>
                                      <button type="button" class="btn btn-primary ml-1" data-dismiss="modal">

                                        <span class="">Submit</span>
                                      </button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                        </form>
                        <div class="text-center h-100px">
                            <h5 class="font-size-h5 mb-3 mt-3 text-dark">
                                or Login with
                            </h5>
                            <div class="">
                                <a href="#"><img class="img-fluid w-45px" src="./assets/images/social/fb.png" alt="social1"></a>
                                <a href="#"><img class="img-fluid w-45px ml-2" src="./assets/images/social/gp.png" alt="social1"></a>
                                <a href="#"><img class="img-fluid w-45px ml-2" src="./assets/images/social/pn.png" alt="social1"></a>
                                <a href="#"><img class="img-fluid w-45px ml-2" src="./assets/images/social/tw.png" alt="social1"></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection
