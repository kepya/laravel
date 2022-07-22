</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2020</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
<i class="fas fa-angle-up"></i>
</a>

<!-- Type Modal -->
<div class="modal fade" id="typeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create a product Type</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="/admin/products_types/create" class="user">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user"
                            name="type" placeholder="Enter the type" required>
                    </div>
                    <hr>
                    <div class="row float-right mt-3">
                        <a href="#">
                            <button href="#" class="btn btn-primary btn-user" name="submit" type="submit">
                                Proceed
                            </button>
                        </a>
                        <a href="#">
                            <button class="btn btn-secondary btn-user ml-2" type="button" data-dismiss="modal">Cancel</button>
                        </a>
                    </div>
                </form>
                
            </div>
           <!--  <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" type="submit" id="edit" href="#">Proceed</a>
            </div> -->
        </div>
    </div>
</div>





<!-- Bootstrap core JavaScript-->
<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>



<!-- Core plugin JavaScript-->
<script src="/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="/js/sb-admin-2.min.js"></script>
<script src="/js/invoice.js"></script>


<!-- Page level custom scripts -->
<script src="/js/demo/chart-area-demo.js"></script>
<script src="/js/demo/chart-pie-demo.js"></script>

</body>

</html>