<div class="d-flex mb-3 justify-content-end">
    <button class="btn ms-sm-2 btn-success" data-bs-toggle="modal" data-bs-target="#advsalesModal">ऍडव्हान्स</button>
    <div class="modal fade" id="advsalesModal" tabindex="-1" aria-labelledby="advsalesLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="advsalesModalLabel">ऍडव्हान्स</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="row">
                        <div class="col-12">
                            <form method="post">
                                <div class="row">
                                    <div class="col-12">



                                        <!-- name="cus_id" id="cus_id" -->

                                        <div class="" id="serch_input_customer">
                                            <label class="form-label fw-bold">ग्राहक</label>
                                            <div class="input-group search-box" id="Search_input_fild">
                                                <input type="text" name="customer_Search" id="customer_search_advance"
                                                    class="form-control mb-3"
                                                    oninput="searchCustomersAdvance(this.value)"
                                                    placeholder="ग्राहक शोधा..." required>
                                                <input type="hidden" class="form-select item_name" name="cus_id"
                                                    id="cus_id" required>
                                            </div>
                                            <div class="search-results position-relative"
                                                id="customer_search_results_Div_Advance">
                                            </div>
                                        </div>




                                        <script>
                                        function searchCustomersAdvance(value) {
                                            console.log(value)
                                            $.ajax({
                                                type: "GET",
                                                url: "ajax_load_customer_data",
                                                data: {
                                                    searchInput: value,
                                                    type: 'advance'
                                                },
                                                success: function(data) {
                                                    $('#customer_search_results_Div_Advance').html(data);
                                                },
                                                error: function(xhr, status,
                                                    error) {
                                                    console.error(
                                                        error);
                                                }
                                            });
                                        }

                                        function updateCustomerSearchAdvance(ID, Name, Totle) {
                                            // Assuming you have the input field with id 'customer_search'
                                            // $('#customer_search').val(value);
                                            console.log(ID, Name)
                                            $('#customer_search_advance').val(Name);
                                            $('#cus_id').val(ID);
                                            $('#bal_amt').val((Totle));
                                            $('#customer_search_results_Div_Advance').html('');

                                        }
                                        </script>




                                        <div class="col-12 my-3">
                                            <div class="form-group">
                                                <input id="bal_amt" type="text" name="bal_amt" class="form-control"
                                                    placeholder="प्रलंबित रक्कम" readonly
                                                    oninput="allowType(event, 'number')">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input id="adv_amt" type="text" name="again_adv_amt" placeholder="रक्कम"
                                                    class="form-control" oninput="allowType(event, 'number')" required>
                                            </div>
                                            <div class="form-group mt-3">
                                                <input id="totbal" type="text" name="totbal" class="form-control"
                                                    placeholder="शिल्लक रक्कम" oninput="allowType(event, 'number')"
                                                    required readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" name="adv_sales" class="btn btn-success me-2 text-white mt-3">जतन
                                    करा</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>