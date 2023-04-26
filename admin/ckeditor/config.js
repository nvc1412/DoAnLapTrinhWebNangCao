/**
 * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
  // Define changes to default configuration here. For example:
  // config.language = 'fr';
  // config.uiColor = '#AADC6E';

  // Bỏ thẻ <p> được tự động thêm vào
  config.autoParagraph = false;

  // Đổi thẻ <p> thành <br/> khi ấn xuống dòng
  config.enterMode = CKEDITOR.ENTER_BR;
  config.forceEnterMode = true;

  config.filebrowserBrowseUrl =
    "http://localhost/DoAnWeb/admin/ckeditor/ckfinder/ckfinder.html";
  config.filebrowserImageBrowseUrl =
    "http://localhost/DoAnWeb/admin/ckeditor/ckfinder/ckfinder.html?type=Images";
  config.filebrowserUploadUrl =
    "http://localhost/DoAnWeb/admin/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files";
  config.filebrowserImageUploadUrl =
    "http://localhost/DoAnWeb/admin/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images";
};
