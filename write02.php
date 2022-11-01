<?
	include 'head.php';
?>




<div id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

		<?
			include 'sidemenu.php';
		?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">

				<?
					include 'nav.php';
				?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                  

                    <!-- Content Row -->

						
						<div class="card shadow mb-4">
							<div class="card-body">
								<p class="tit">과제정보</p>

								<div class="tbl-st">
									<div class="cols">
										<div class="cols_20 cols_ th">과제명</div>
										<div class="cols_80 cols_">산업정보 연계 주요국 특허 영-한 데이터</div>
									</div>
									<div class="cols">
										<div class="cols_20 cols_ th">과제기간</div>
										<div class="cols_80 cols_">
											<label>
												<input type="date" id="start" name="start" value="2021-08-01" class="form-control">
											</label>
											~ 
											<label>
												<input type="date" id="end" name="end" value="2021-08-31" class="form-control">
											</label>
										</div>
									</div>
								</div>

								<p class="tit">사업개요</p>

								<div class="tbl-st">
									<div class="cols">
										<div class="cols_20 cols_ th">사업목적</div>
										<div class="cols_80 cols_">
											<textarea id="txt02" class="form-control" name="txt" cols="50" rows="5" style="width:100%; resize:none;"></textarea>
										</div>
									</div>
									<div class="cols">
										<div class="cols_20 cols_ th">추진근거</div>
										<div class="cols_80 cols_">
											<textarea id="txt02" class="form-control" name="txt" cols="50" rows="5" style="width:100%; resize:none;"></textarea>
										</div>
									</div>

									<div class="cols">
										<div class="cols_20 cols_ th">추진경위</div>
										<div class="cols_80 cols_">
											<textarea id="txt03" class="form-control" name="txt" cols="50" rows="5" style="width:100%; resize:none;"></textarea>
										</div>
									</div>
								</div>

								<p class="tit">기관정보</p>
								
								<div class="mo-hand2 mo-hand" style="text-align:right;">
									<span class="scorll-hand">
										<img src="img/scroll_hand.gif" style="max-width:100%;">
									</span>
								</div>

								<div class="tbl-st-wrap01 tbl-st-wrap">
									<div class="tbl-st-w01 tbl-st-w tbl-st mb20 clearfix">
										<div class="rows br-r">
											<div class="cols_ th txt-c">인건비구분</div>
											<div class="cols_">
												<select name="dataTable_length" aria-controls="dataTable" class="w150 custom-select custom-select-sm form-control form-control-sm">
													<option value="">보수(정규직)</option>
													<option value="">상용임금(계약직)</option>
													<option value="">일용임금(직접고용)</option>
												</select>
											</div>
										</div>
										<div class="rows br-r">
											<div class="cols_ th txt-c">성명</div>
											<div class="cols_">
												<label>
													<input type="text" id="name" name="name" class="w150 form-control">
												</label>
											</div>
										</div>
										<div class="rows br-r">
											<div class="w190 cols_ th txt-c">주민번호</div>
											<div class="cols_">
												<label>
													<input type="text" id="year01" class="form-control dp_ib" name="year" placeholder="19900101" style="width:100px"> - <input type="text" id="year02" class="w35 form-control dp_ib" name="year" placeholder="1">
												</label>
											</div>
										</div>
										<div class="rows br-r">
											<div class="cols_ th txt-c">국적</div>
											<div class="cols_">
												<label>
													<input type="text" id="" name="" placeholder="한국" class="w150 form-control">
												</label>
											</div>
										</div>
										<div class="rows br-r">
											<div class="cols_ th txt-c">거주지</div>
											<div class="cols_">
												<select name="dataTable_length" aria-controls="dataTable" class="w80 custom-select custom-select-sm form-control form-control-sm">
													<option value="">서울</option>
													<option value="">부산</option>
													<option value="">대구</option>
													<option value="">인천</option>
													<option value="">광주</option>
													<option value="">대전</option>
													<option value="">울산</option>
													<option value="">세종</option>
													<option value="">경기</option>
													<option value="">강원</option>
													<option value="">충북</option>
													<option value="">충남</option>
													<option value="">전북</option>
													<option value="">전남</option>
													<option value="">경북</option>
													<option value="">경남</option>
													<option value="">제주</option>
												</select>
											</div>
										</div>
										<div class="rows br-r">
											<div class="cols_ th txt-c">기관 내 채용일자</div>
											<div class="cols_">
												<label>
													<input type="text" id="" name="" class="w150 form-control">
												</label>
											</div>
										</div>
										<div class="rows br-r">
											<div class="cols_ th txt-c">전환채용여부</div>
											<div class="cols_">
												<select name="dataTable_length" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm">
													<option value="">O</option>
													<option value="">X</option>
												</select>
											</div>
										</div>
										<div class="rows br-r">
											<div class="cols_ th txt-c">투입구분</div>
											<div class="cols_">
												<select name="dataTable_length" aria-controls="dataTable" class="w80 custom-select custom-select-sm form-control form-control-sm">
													<option value="">투입</option>
													<option value="">철수</option>
													<option value="">교체</option>
												</select>
											</div>
										</div>
										<div class="rows br-r">
											<div class="cols_ th txt-c">근무시작일</div>
											<div class="cols_">
												<label>
													<input type="date" id="" name="" class="w150 form-control">
												</label>
											</div>
										</div>
										<div class="rows br-r">
											<div class="cols_ th txt-c">근무종료일</div>
											<div class="cols_">
												<label>
													<input type="date" id="" name="" class="w150 form-control">
												</label>
											</div>
										</div>

										<div class="rows br-r">
											<div class="cols_ th txt-c">투입비율</div>
											<div class="cols_">
												<label>
													<input type="text" id="" name="" class="w150 form-control">
												</label>
											</div>
										</div>

										<div class="rows br-r">
											<div class="cols_ th txt-c">국민</div>
											<div class="cols_">
												<select name="dataTable_length" aria-controls="dataTable" class="w50 custom-select custom-select-sm form-control form-control-sm">
													<option value="">O</option>
													<option value="">X</option>
												</select>
											</div>
										</div>

										<div class="rows br-r">
											<div class="cols_ th txt-c">건강</div>
											<div class="cols_">
												<select name="dataTable_length" aria-controls="dataTable" class="w50 custom-select custom-select-sm form-control form-control-sm">
													<option value="">O</option>
													<option value="">X</option>
												</select>
											</div>
										</div>

										<div class="rows br-r">
											<div class="cols_ th txt-c">고용</div>
											<div class="cols_">
												<select name="dataTable_length" aria-controls="dataTable" class="w50 custom-select custom-select-sm form-control form-control-sm">
													<option value="">O</option>
													<option value="">X</option>
												</select>
											</div>
										</div>

										<div class="rows br-r">
											<div class="cols_ th txt-c">산재</div>
											<div class="cols_">
												<select name="dataTable_length" aria-controls="dataTable" class="w50 custom-select custom-select-sm form-control form-control-sm">
													<option value="">O</option>
													<option value="">X</option>
												</select>
											</div>
										</div>
										
										<div class="rows">
											<div class="cols_ th txt-c">비고</div>
											<div class="cols_">
												<label>
													<input type="text" id="" name="" class="w150 form-control">
												</label>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>


					<!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
				<?
					include 'footer.php';
				?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

</div>


