<?php

use App\Models\User;
use LdapRecord\Ldap;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnitController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\TitleController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GapAnalysisController;
use App\Http\Controllers\WorkPackageController;
use App\Http\Controllers\Audits\AuditController;
use App\Http\Controllers\Audits\AuditorController;
use App\Http\Controllers\EntityFromFileController;
use App\Http\Controllers\EntitySubGroupController;
use App\Http\Controllers\Reports\ReportController;
use App\Http\Controllers\WorkPackageLogController;
use League\OAuth2\Client\Provider\GenericProvider;
use App\Http\Controllers\Audits\WorkFormController;
use App\Http\Controllers\AuditSuggestionController;
use App\Http\Controllers\Audits\FileUploadController;
use App\Http\Controllers\Audits\AuditEntityController;
use App\Http\Controllers\Audits\AuditAuditorController;
use App\Http\Controllers\Audits\AuditOpinionController;
use App\Http\Controllers\Audits\AuditProgramController;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;
use App\Http\Controllers\Audits\AuditPersonnelController;
use App\Http\Controllers\Management\Roles\RoleController;
use App\Http\Controllers\Management\Users\UserController;
use App\Http\Controllers\Precautions\PrecautionController;
use App\Http\Controllers\CompensatoryControlFormController;
use App\Http\Controllers\Audit_Reports\AuditReportController;
use App\Http\Controllers\DeclarationOfApplicabilityController;
use App\Http\Controllers\Precautions\PrecautionTitleController;
use App\Http\Controllers\Audits\AuditApplicationProcessController;
use App\Http\Controllers\Precautions\PrecautionFromFileController;
use App\Http\Controllers\Audits\PrecautionActivityStatusController;
use App\Http\Controllers\Precautions\PrecautionMainTitleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('/');

//Route::view('index', 'index')->name('index')->middleware(['auth']);

Route::middleware(['auth', 'verified'])->group(function () {

    //Kullanıcı işlemleri
    Route::resource('kullanicilar', UserController::class)->middleware('role:Admin|Super Admin');

    //Role işlemleri
    route::resource('roller', RoleController::class)->middleware('role:Admin|Super Admin');
    Route::get('/roles/{id}/permissions', [RoleController::class, 'getPermissions'])->middleware('role:Admin|Super Admin');
    Route::post('/add-role', [RoleController::class, 'storeRole'])->name('roller.storeRole');

    //Çözüm Önerileri
    Route::get('cozum-onerileri', [PrecautionController::class, 'indexSolutionSuggestions'])->name('cozum-onerileri.index');
    Route::get('cozum-onerileri/create', [PrecautionController::class, 'createSolutionSuggestions'])->name('cozum-onerileri.create');
    Route::post('cozum-onerileri/store', [PrecautionController::class, 'storeSolutionSuggestions'])->name('cozum-onerileri.store');
    Route::get('cozum-onerileri/edit/{id}', [PrecautionController::class, 'editSolutionSuggestions'])->name('cozum-onerileri.edit');
    Route::put('cozum-onerileri/update/{id}', [PrecautionController::class, 'updateSolutionSuggestions'])->name('cozum-onerileri.update');

    Route::get('cozum-onerileri/import', [SolutionSuggestionController::class, 'index'])->name('cozum-onerileri.import');

    Route::get('/export-solutions', [SolutionSuggestionController::class, 'exportSolutions'])->name('export.solutions');
    Route::post('/import-solutions', [SolutionSuggestionController::class, 'importSolutions'])->name('import.solutions');

    //Denetim Önerileri
    Route::get('denetim-onerileri', [PrecautionController::class, 'indexAuditSuggestions'])->name('denetim-onerileri.index');
    Route::get('denetim-onerileri/create', [PrecautionController::class, 'createAuditSuggestions'])->name('denetim-onerileri.create');
    Route::post('denetim-onerileri/store', [PrecautionController::class, 'storeAuditSuggestions'])->name('denetim-onerileri.store');
    Route::get('denetim-onerileri/edit/{id}', [PrecautionController::class, 'editAuditSuggestions'])->name('denetim-onerileri.edit');
    Route::put('denetim-onerileri/update/{id}', [PrecautionController::class, 'updateAuditSuggestions'])->name('denetim-onerileri.update');

    Route::get('denetim-onerileri/import', [AuditSuggestionController::class, 'index'])->name('denetim-onerileri.import');

    Route::get('/export-audit-suggestion', [AuditSuggestionController::class, 'exportAuditSuggestions'])->name('export.audit-suggestion');
    Route::post('/import-audit-suggestion', [AuditSuggestionController::class, 'importAuditSuggestions'])->name('import.audit-suggestion');






    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Performance Agent Routes
    Route::prefix('performance')->group(function () {
        // Categories
        Route::resource('categories', \App\Http\Controllers\Web\CategoryViewController::class);
        
        // Keywords  
        Route::resource('keywords', \App\Http\Controllers\Web\KeywordViewController::class);
        Route::get('keywords-test', [\App\Http\Controllers\Web\KeywordViewController::class, 'test'])->name('keywords.test');
        Route::get('keywords-import', [\App\Http\Controllers\Web\KeywordViewController::class, 'import'])->name('keywords.import');
        Route::post('keywords-import', [\App\Http\Controllers\Web\KeywordViewController::class, 'importPost'])->name('keywords.import.post');
        
        // Activities
        Route::resource('activities', \App\Http\Controllers\Web\ActivityViewController::class);
        Route::get('activities-tagged', [\App\Http\Controllers\Web\ActivityViewController::class, 'tagged'])->name('activities.tagged');
        Route::get('activities-untagged', [\App\Http\Controllers\Web\ActivityViewController::class, 'untagged'])->name('activities.untagged');
        Route::get('activities-auto-tag', [\App\Http\Controllers\Web\ActivityViewController::class, 'autoTagPage'])->name('activities.auto-tag');
        Route::post('activities-auto-tag-run', [\App\Http\Controllers\Web\ActivityViewController::class, 'autoTagRun'])->name('activities.auto-tag.run');
        
        // Statistics
        Route::get('statistics', [\App\Http\Controllers\Web\StatisticsViewController::class, 'index'])->name('statistics.index');
        Route::get('statistics-tagging-rate', [\App\Http\Controllers\Web\StatisticsViewController::class, 'taggingRate'])->name('statistics.tagging-rate');
        Route::get('statistics-time-distribution', [\App\Http\Controllers\Web\StatisticsViewController::class, 'timeDistribution'])->name('statistics.time-distribution');
        Route::get('statistics-work-other', [\App\Http\Controllers\Web\StatisticsViewController::class, 'workOther'])->name('statistics.work-other');
        
        // Computer Users
        Route::resource('computer-users', \App\Http\Controllers\Web\ComputerUserController::class);
    });
    
    Route::resource('birim', UnitController::class);
    Route::resource('unvan', TitleController::class);
    Route::resource('varlik_gruplari', EntitySubGroupController::class)->middleware('permission:Varlık Grubu İşlemleri');
    Route::resource('varlik', EntityController::class)->middleware('permission:Varlık İşlemleri');

    //Dosyadan Yükleme
    Route::get('/entity_from_file', [EntityFromFileController::class, 'index'])->name('entity_from_file');
    Route::post('/import-entity', [EntityFromFileController::class, 'import'])->name('import');
  
    //Ana gruba göre varlık grubunu almak için jquery ile
    Route::get('/get-sub-groups', [EntityController::class, 'getSubGroups']);

    //Kullanıcı bilgilerin gelmesi
    Route::get('/get-user', [UserController::class, 'getUser']);



    Route::get('/refresh', [DeclarationOfApplicabilityController::class, 'fetch_data'])->name('uygulanabilirlik_bildirgesi.refresh');

    Route::resource('uygulanabilirlik_bildirgesi', DeclarationOfApplicabilityController::class)->middleware('permission:Uygulanabilirlik Bildirgesi');

    //Boşluk Analizi
    Route::resource('bosluk_analizi', GapAnalysisController::class)->except(['destroy', 'edit'])->middleware('permission:Boşluk Analizi');
    Route::get('bosluk-analizi/dublicate', [GapAnalysisController::class, 'showDublicate'])->name('bosluk_analizi.dublicate');
    Route::post('bosluk-analizi/list', [GapAnalysisController::class, 'list'])->name('bosluk_analizi.list');

    Route::post('bosluk-analizi/copy-answers', [GapAnalysisController::class, 'copy_answers'])->name('bosluk_analizi.copy_answers');
    Route::post('/bosluk-analizi/getQuestions', [GapAnalysisController::class, 'getQuestions']);
    Route::post('/bosluk-analizi/getBgysClauses', [GapAnalysisController::class, 'getBgysClauses']);

    Route::post('bosluk-analizi/get-Gap-Analysis', [GapAnalysisController::class, 'getGapAnalysisData'])->name('bosluk_analizi.get-Gap-Analysis');

    Route::post('bosluk-analizi/risk_kaydet',[GapAnalysisController::class,'saveRisk'])->name('bosluk_analizi.saveRisk');

    //Telafi edici kontrol formları
    Route::resource('telafi-edici-kontrol-formlari', CompensatoryControlFormController::class)->except(['create', 'show'])->middleware('permission:Telafi Edici Kontrol Formları');
    Route::post('telafi-edici-kontrol-formlari/list', [CompensatoryControlFormController::class, 'list'])->name('telafi_edici_kontrol_formlari.list')->middleware('permission:Telafi Edici Kontrol Formları');
    Route::post('telafi-edici-kontrol-formlari/fetch-data', [CompensatoryControlFormController::class, 'fetchData'])->name('telafi_edici_kontrol_formlari.fetch-data');
    Route::get('telafi-edici-kontrol-formlari/get-all', [CompensatoryControlFormController::class, 'fetchAllCompensatoryControlForm']);


    //Anketler
    Route::resource('anketler', SurveyController::class)->middleware('permission:Anket İşlemleri');
    Route::get('anket/katilimcilar', [SurveyController::class, 'addParticipant'])->name('anketler.katilimcilar');
    Route::post('anket/katilimci-ekle', [SurveyController::class, 'storeParticipant'])->name('anketler.katilimci-ekle');
    Route::post('anket/katilimci-list', [SurveyController::class, 'listParticipant'])->name('anketler.katilimci-list');
    Route::delete('anket/katilimci-sil/{id}', [SurveyController::class, 'destroyParticipant'])->name('anketler.katilimci-sil');
    Route::get('anket/ankete-git/{sub_group_id}/{survey_id}', [SurveyController::class, 'showSurvey'])->name('anketler.ankete-git');
    Route::post('anket/anket-sonuc-kaydet', [SurveyController::class, 'storeSurveyResult'])->name('anketler.sonuc-kaydet');
    Route::post('anket/onaylanacak-anket/{id}', [SurveyController::class, 'surveyToBeApproved'])->name('anket.onaylanacak-anket');

    //Anket yetkilisine ait
    Route::post('anket/cevaplar/{id}', [SurveyController::class, 'showSurveyResults'])->name('anket.cevaplar');


    //Anket Onayla
    Route::post('/anket-onayla', [SurveyController::class, 'approveSurvey']);

    //anket cevap şıkkı ve gerekçeleri göster
    Route::post('/show-answer-and-description', [SurveyController::class, 'showAnswerAndDescpription']);
    Route::post('/show-answer-survey', [SurveyController::class, 'showAnswerSurvey']);
    Route::post('/save-approved_survey_result', [SurveyController::class, 'saveApprovedSurveyResult']);



    //Anketler filter
    Route::post('/surveyStatus', [DashboardController::class, 'surveyStatus'])->name('anketler.surveyStatus');

    //Anket EK-C1
    Route::get('/export-attachment-c1/{id1}', [SurveyController::class, 'exportAttachmentC1'])->name('export-attachment-c1');


    //İş Paketleri
    Route::resource('is-paketleri', WorkPackageController::class)->except(['create', 'show'])->middleware('permission:İş Paketleri');
    Route::post('is-paketleri/fetch-data', [WorkPackageController::class, 'fetchData'])->name('is_paketleri.fetch-data');
    Route::post('is-paketleri/fetch-affected-precautions', [WorkPackageController::class, 'fetchAffectedData']);


    Route::get('is-paketleri/get-all', [WorkPackageController::class, 'fetchAllWorkPackages']);
    Route::post('is-paketleri/copy', [WorkPackageController::class, 'copyWorkPackage']);
    Route::get('is-paketleri-gecmis/{id?}', [WorkPackageLogController::class, 'index'])->name('is-paketleri-gecmis.index');
    Route::post('is-paketleri/get-stages', [WorkPackageController::class, 'getStages']);
    Route::post('is-paketleri/get-users', [WorkPackageController::class, 'getUsers']);



    //Denetim işlemleri
    Route::resource('denetci', AuditorController::class)->except(['show'])->middleware('permission:Denetçi İşlemleri');

    //Bilgi Alınan Personel
    Route::resource('bilgi-alinan-personel', InformationReceivedPersonnelController::class)->except(['show'])->middleware('permission:Bilgi Alınan Personel');

    //Denetim Oluşturma işlemleri
    Route::resource('denetim', AuditController::class)->except(['show'])->middleware('permission:Denetim Oluştur');

    //Denetime Denetçi Ata 
    Route::resource('denetci-ata', AuditAuditorController::class)->except(['show'])->middleware('permission:Denetime Denetçi Ata');

    //Denetime Personel Ata 
    Route::resource('personel-ata', AuditPersonnelController::class)->except(['show', 'edit', 'update'])->middleware('permission:Denetime Personel Ata');

    //Denetime Varlık Ata 
    Route::resource('denetime-varlik-ata', AuditEntityController::class)->except(['show', 'edit', 'update'])->middleware('permission:Denetime Varlık Ata');
    Route::get('/denetime-atanan-varliklar/{id}', [AuditEntityController::class, 'getAuditEntities']);


    //Denetim Programı
    Route::resource('denetim-programi', AuditProgramController::class)->except(['show', 'edit', 'update'])->middleware('permission:Denetim Programı');
    Route::post('denetim-programi/list', [AuditProgramController::class, 'list'])->name('denetim-programi.list');
    Route::post('/save-audit-program', [AuditProgramController::class, 'saveAuditProgram']);

    //Uygulama Süreci Değerlendir
    Route::get('uygulama-sureci', [AuditApplicationProcessController::class, 'index'])->name('uygulama-sureci.index')->middleware('permission:Uygulama Süreci Değerlendir');
    Route::post('uygulama-sureci/list', [AuditApplicationProcessController::class, 'list'])->name('uygulama-sureci.list');
    Route::post('/save-audit-application-process', [AuditApplicationProcessController::class, 'saveAuditApplicationProcess']);

    //Soruların getirilmesi
    Route::post('/pas/getQuestions', [PrecautionActivityStatusController::class, 'getQuestions']);


    //Bulgular
    Route::post('/to-finding-modal', [PrecautionActivityStatusController::class, 'toFinding']);
    Route::post('/to-finding2-modal', [AuditApplicationProcessController::class, 'toFinding2']);

    Route::post('/save-finding', [PrecautionActivityStatusController::class, 'saveFinding']);
    Route::post('/save-finding2', [AuditApplicationProcessController::class, 'saveFinding2']);

    Route::get('/bulgular2', [AuditApplicationProcessController::class, 'indexFinding'])->name('uygulama-sureci-degerlendir.bulgular')->middleware('permission:Bulgular');;

    Route::post('/bulgular-goster2', [AuditApplicationProcessController::class, 'listFinding'])->name('uygulama-sureci-degerlendir.finding-list');

    Route::Post('/bulgu-guncelle', [PrecautionActivityStatusController::class, 'updateFinding']);
    Route::Post('/bulgu-guncelle2', [AuditApplicationProcessController::class, 'updateFinding']);


    Route::post('/file-upload', [FileUploadController::class, 'upload']);
    Route::post('/show-files', [FileUploadController::class, 'show']);
    Route::post('/file-upload-aap', [FileUploadController::class, 'uploadAap']);
    Route::post('/show-files-aap', [FileUploadController::class, 'showAap']);

    Route::post('/file-upload-gap', [FileUploadController::class, 'uploadGap']);
    Route::post('/show-files-gap', [FileUploadController::class, 'showGap']);

    Route::post('/delete-file-gap', [FileUploadController::class, 'deleteFile'])->name('delete-file-gap');
    Route::post('/delete-file-pas', [FileUploadController::class, 'deleteFilePas'])->name('delete-file-pas');








    //Çalışma Formları
    Route::resource('calisma-formlari', WorkFormController::class)->except(['destroy', 'edit', 'show', 'update'])->middleware('permission:Çalışma Formları');
    //cRoute::post('calisma-formlari/list', [WorkFormController::class, 'list'])->name('calisma-formlari.list');

    Route::match(['get', 'post'], 'calisma-formlari/list', [WorkFormController::class, 'list'])->name('calisma-formlari.list');
    Route::GET('calisma-formlari/finding-download/{id1}/{id2}', [WorkFormController::class, 'downloadFilteredZip'])->name('calisma-formlari.finding-download');
    Route::GET('calisma-formlari/finding-delete/{id1}/{id2}', [WorkFormController::class, 'deleteFindingFiles'])->name('calisma-formlari.finding-delete');
    Route::get('/export-work-form/{id1}/{id2}', [WorkFormController::class, 'exportArray'])->name('export-work-form');
    Route::get('/export-work-form-7/{id1}/{id2}', [WorkFormController::class, 'exportForm7Array'])->name('export-work-form-7');
    Route::get('/calisma-formu/{id}', [WorkFormController::class, 'getWorkForm']);



    //Denetim Raporları
    Route::get('/denetim-raporlari', [AuditReportController::class, 'index'])->name('denetim-raporlari.index')->middleware('permission:Raporlar');
    Route::get('/export-attachment-a/{id1}/{format}', [AuditReportController::class, 'exportAttachmentA'])->name('export-attachment-a');
    Route::get('/export-attachment-b/{id1}/{format}', [AuditReportController::class, 'exportAttachmentB'])->name('export-attachment-b');
    Route::get('/export-attachment-c/{id1}/{format}', [AuditReportController::class, 'exportAttachmentC'])->name('export-attachment-c');
    Route::get('/export-attachment-c2/{id1}/{format}', [AuditReportController::class, 'exportAttachmentC2'])->name('export-attachment-c2');
    Route::get('/export-attachment-e/{id1}/{format}', [AuditReportController::class, 'exportAttachmentE'])->name('export-attachment-e');
    Route::get('/export-attachment-f/{id1}/{format}', [AuditReportController::class, 'exportAttachmentF'])->name('export-attachment-f');
    Route::get('/export-attachment-g/{id1}/{format}', [AuditReportController::class, 'exportAttachmentG'])->name('export-attachment-g');
    Route::get('/export-attachment-g2/{id1}/{format}', [AuditReportController::class, 'exportAttachmentG2'])->name('export-attachment-g2');


    //Diğer Raporlar
    Route::get('/export-gap-analysis/{subGroupId}/{format}', [ReportController::class, 'exportGapAnalysis'])->name('export-gap-analysis');
    Route::get('/export-entities', [ReportController::class, 'exportEntities'])->name('exportEntities');



    //Denetim Görüşü
    Route::resource('denetim-gorusu', AuditOpinionController::class)->except(['edit', 'show', 'update'])->middleware('permission:Raporlar');
    Route::post('denetim-gorusu/list', [AuditOpinionController::class, 'list'])->name('denetim-gorusu.list')->middleware('permission:Raporlar');
    Route::get('/export-auditOpinion/{id}', [AuditOpinionController::class, 'exportAuditOpinionPdf'])->name('export-auditOpinion');

    //Risk Yönetimi

    Route::post('/risk_yonetimi/list',[\App\Http\Controllers\RiskController::class,'list_threats'])->name('risk_yonetimi.list');
    Route::post('/risk_yonetimi/save',[\App\Http\Controllers\RiskController::class,'save_threats'])->name('risk_yonetimi.save');
    Route::post('/risk_yonetimi/get_risk_meter',[\App\Http\Controllers\RiskController::class,'get_risk_meter'])->name('risk_yonetimi.get_risk_meter');

    // BGYS Doküman Yükleme
    Route::get('/dokuman',[\App\Http\Controllers\FileController::class,'index'])->name('dokuman.index')->middleware('permission:Dokumanlar');
    Route::post('/dokuman',[\App\Http\Controllers\FileController::class,'insert'])->name('dokuman.insert')->middleware('permission:Dokumanlar');
    Route::post('/dokuman/get',[\App\Http\Controllers\FileController::class,'get'])->name('dokuman.get')->middleware('permission:Dokumanlar');
    Route::get('/dokuman/list',[\App\Http\Controllers\FileController::class,'list'])->name('dokuman.list')->middleware('permission:Dokumanlar');
    Route::get('/dokuman/download',[\App\Http\Controllers\FileController::class,'download'])->name('dokuman.download')->middleware('permission:Dokumanlar');
    Route::post('/dokuman/upload',[\App\Http\Controllers\FileController::class,'upload'])->name('dokuman.upload')->middleware('permission:Dokumanlar');
    Route::post('/dokuman/versions',[\App\Http\Controllers\FileController::class,'versions'])->name('dokuman.versions')->middleware('permission:Dokumanlar');
    Route::post('/dokuman/getversions',[\App\Http\Controllers\FileController::class,'getversions'])->name('dokuman.getversions')->middleware('permission:Dokumanlar');
    Route::post('/dokuman/getfilename',[\App\Http\Controllers\FileController::class,'getfilename'])->name('dokuman.getfilename')->middleware('permission:Dokumanlar');
    Route::post('/dokuman/updatefilename',[\App\Http\Controllers\FileController::class,'updatefilename'])->name('dokuman.updatefilename')->middleware('permission:Dokumanlar');
    Route::get('/dokuman/test',[\App\Http\Controllers\FileController::class,'test'])->name('dokuman.test')->middleware('permission:Dokumanlar');


    //Notify

    Route::post('/notify/checkread',[\App\Http\Controllers\NotificationController::class,'checkread'])->name('notify.checkread');

});




// Route::view('login', 'authentication.login')->name('login');

Route::prefix('authentication')->group(function () {
    //Route::view('login', 'authentication.login')->name('login');
    // Route::view('register', 'authentication.register')->name('register');
});

// Route::get('/test-ldap-user', function () {
//     // Kullanıcıyı LDAP içinde arayın
//     $user = \LdapRecord\Models\Entry::where('uid', '=', 'riemann')->first();

//     if ($user) {
//         $email = $user->getFirstAttribute('mail'); // Kullanıcının mail özelliğini alın
//         return 'LDAP kullanıcı bulundu: ' . $user->getFirstAttribute('cn') . '<br>E-posta: ' . $email;
//     }

//     return 'LDAP kullanıcısı bulunamadı2';
// });

Route::get('/test-ldap-user', function () {
    // Kullanıcıyı LDAP içinde arayın
    $user = \LdapRecord\Models\Entry::where('uid', '=', 'riemann')->first();

    if ($user) {
        $email = $user->getFirstAttribute('mail'); // Kullanıcının mail özelliğini alın
        //return 'LDAP kullanıcı bulundu: ' . $user->getFirstAttribute('cn') . '<br>E-posta: ' . $email;
    } else {
        return 'LDAP kullanıcısı bulunamadı';
    }

    $credentials = [
        'mail' => $email, // Test kullanıcı e-postası
        'password' => 'password' // Test kullanıcı şifresi
    ];

    Log::info('LDAP kimlik doğrulama başlıyor. Giriş bilgileri: ', $credentials);

    try {
        if (Auth::guard('ldap')->attempt($credentials)) {
            $ldapUser = Auth::guard('ldap')->user();
            return 'LDAP kullanıcı doğrulandı: ' . $ldapUser->getFirstAttribute('cn') . '<br>E-posta: ' . $ldapUser->getFirstAttribute('mail');
        } else {
            Log::error('LDAP doğrulama başarısız. Giriş bilgileri: ', $credentials);
            $ldap = app(Ldap::class);
            $detailedError = $ldap->getDetailedError();
            if ($detailedError) {
                Log::error('LDAP Hata: ' . json_encode($detailedError));
                return 'LDAP doğrulama başarısız: ' . json_encode($detailedError);
            }
            return 'LDAP doğrulama başarısız';
        }
    } catch (\Exception $e) {
        Log::error('LDAP kimlik doğrulama sırasında bir hata oluştu: ' . $e->getMessage());
        return 'LDAP kimlik doğrulama sırasında bir hata oluştu: ' . $e->getMessage();
    }
});

