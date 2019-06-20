# Google Drive Api

* Author: Majksa
* Version: 1.0.0
* PHP version: 5.6+

## Usage

1. Go to [https://console.developers.google.com/](https://console.developers.google.com/)
2. Create new project
3. Create O2Auth credentials with redirect uri and download them
4. Load using `include '/path/to/GoogleDriveApi/GoogleDriveApi.php';`
5. When creating `new GoogleDriveApi()` send path to credentials as the parameter.

## Methods

* log out `logOut()`
* get email `getEmail()`
* list files `listFiles($fields = "files(id, name, owners)")`
* create folder `createFolder($name, $parentId = "root")`
* upload file `uploadFile($fullName, $mimeType, $fullPath, $parentId = "root")`
* upload file basic `uploadFileBasic($name, $type, $extension, $pathToFileDir, $parentId = "root")`
* create file `createFile($fullName, $mimeType, $parentId = "root")`
* create file basic `createFileBasic($name, $type, $extension, $parentId = "root")`
* move file `moveFile($fileId, $folderId)`
* download file `downloadFile($fileId)`
* test files owners `testFilesOwners()`
* set verified owners `setVerifiedOwner($ids)`
