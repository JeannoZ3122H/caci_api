<?php

namespace App\Http\Controllers;

use App\Models\faq;
use Illuminate\Http\Request;
use App\Models\AgendasModels;
use App\Services\MessageService;
use App\Services\SlgGenrateService;
use App\Services\UploadFileService;
use App\Http\Controllers\Controller;
use App\Models\CalculatorFraisModel;
use App\Models\CommentDevenirModel;
use App\Models\DocumentJoin;
use App\Models\SoumettreDocsModel;

class InfosPratiquesController extends Controller
{


    protected $middleware = [
        'auth:api', // Reference the middleware group
    ];

    public function __construct()
    {
        $this->middleware;
    }


// ======= START =========== ======= //
// ======= =========== FAQ =========== ======= //
    public function index_faq(){
        try {
            $list = faq::OrderByDesc('id')->get();
            if($list != null){return $list;}
            else{return $list = [];}
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
    public function store_faq(Request $request){
        try {
            if(empty($request->ask)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('question')
                    ]
                );
            endif;
            if(empty($request->keyword)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('mot clé')
                    ]
                );
            endif;

            $add = new faq();
            $add->author_id = 0;
            $add->ask = $request->ask;
            $add->answere = $request->answere;
            $add->keyword = $request->keyword;
            $add->category_ask = $request->category_ask;
            $add->slug = SlgGenrateService::slgGenerate();

            if($add->save()){
                return response()->json(
                    [
                        'status' => 'Succès',
                        'code' => 100,
                        'message' => MessageService::code100()
                    ]
                );
            }else{
                return response()->json(
                    [
                        'status' => 'Erreur',
                        'code' => 400,
                        'message' => MessageService::code400()
                    ]
                );
            }
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'Erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
    public function update_faq(Request $request, $slg){
        try {
            if(isset($slg)):
                if(empty($request->answere)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('reponse')
                        ]
                    );
                endif;
                if(empty($request->category_ask)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('catégorie')
                        ]
                    );
                endif;
                if(empty($request->author_id)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('auteur')
                        ]
                    );
                endif;

                $add = faq::Where('slug', $slg)->first();
                $add->author_id = $request->author_id;
                $add->answere = $request->answere;
                $add->keyword = $request->keyword;
                $add->category_ask = $request->category_ask;
                $add->slug = SlgGenrateService::slgGenerate();
                if($add->save()){
                    return response()->json(
                        [
                            'status' => 'Succès',
                            'code' => 200,
                            'message' => MessageService::code100()
                        ]
                    );
                }
            else
                return response()->json(
                    [
                        'status' => 'Erreur',
                        'code' => 400,
                        'message' => MessageService::code400()
                    ]
                );
            endif;
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'Erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
    public function delete_faq($slg){
        try {
            if(!isset($slg)):
                return response()->json(
                    [
                        'code' => 300,
                        'status' => 'Erreur',
                        'message' => MessageService::code300()
                    ]
                );
            endif;
            $resp = faq::where('slug', '=', $slg)->delete();
            if($resp){
                return response()->json(
                    [
                        'code' => 100,
                        'status' => 'Succès',
                        'message' => MessageService::code100()
                    ]
                );
            }else{
                return response()->json(
                    [
                        'code' => 400,
                        'status' => 'Erreur',
                        'message' => MessageService::code400()
                    ]
                );
            }
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'Erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
// ======= =========== FAQ =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== COMMENT DEVENIR EXPERT... =========== ======= //
    public function index_comment_devenir(){
        try {
            $list = CommentDevenirModel::Join('admin_account_models', 'comment_devenir_models.author_id', '=', 'admin_account_models.id')
            ->select('admin_account_models.*', 'admin_account_models.id as user_id', 'comment_devenir_models.*')->get();
            if($list != null){return $list;}
            else{return $list = [];}
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
    public function store_comment_devenir(Request $request){
        try {

            // return $request->all();
            if(empty($request->author_id)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('auteur')
                    ]
                );
            endif;
            if(empty($request->libelle)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('libellé')
                    ]
                );
            endif;
            if(empty($request->description)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('description')
                    ]
                );
            endif;

            $add = new CommentDevenirModel();
            $add->author_id = $request->author_id;
            $add->libelle = $request->libelle;
            $add->subTitle = $request->subTitle;
            $add->code_ref = SlgGenrateService::generateCodeRef();
            $add->description = $request->description;
            if(!empty($request->illustration)):
                $add->illustration = UploadFileService::uploadFile($request, 'illustration', 'docs');
            else:
                $add->illustration = null;
            endif;
            $add->slug = SlgGenrateService::slgGenerate();

            if($add->save()){
                return response()->json(
                    [
                        'status' => 'Succès',
                        'code' => 100,
                        'data' => $add->code_ref,
                        'message' => MessageService::code100()
                    ]
                );
            }
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'Erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
    public function update_comment_devenir(Request $request, $slg){
        try {
            if(isset($slg)){

                if(empty($request->author_id)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('auteur')
                        ]
                    );
                endif;
                if(empty($request->libelle)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('libellé')
                        ]
                    );
                endif;
                if(empty($request->description)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('description')
                        ]
                    );
                endif;

                $data = CommentDevenirModel::Where('slug', '=', $slg)->first();
                if($data){
                    $data->author_id = $request->author_id;
                    $data->libelle = $request->libelle;
                    $data->subTitle = $request->subTitle;
                    $data->description = $request->description;
                    if(!empty($request->illustration)):
                        $data->illustration = UploadFileService::uploadFile($request, 'illustration', 'docs');
                    else:
                        $data->illustration = null;
                    endif;
                    if($data->save()){
                        return response()->json(
                            [
                                'status' => 'Succès',
                                'code' => 200,
                                'message' => MessageService::code200(),
                            ]
                        );
                    };
                }else{
                    return response()->json(
                        [
                            'status' => 'Erreur',
                            'code' => 400,
                            'message' => MessageService::code400(),
                        ]
                    );
                }
            }else{
                return response()->json(
                    [
                        'code' => 300,
                        'status' => 'Erreur',
                        'message' => MessageService::code300()
                    ]
                );
            }
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'erreur',
                    'code' => 300,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
    public function delete_comment_devenir($slg){
        try {
            if(!isset($slg)):
                return response()->json(
                    [
                        'code' => 300,
                        'status' => 'Erreur',
                        'message' => MessageService::code300()
                    ]
                );
            endif;
            $resp = CommentDevenirModel::where('slug', '=', $slg)->delete();
            if($resp){
                return response()->json(
                    [
                        'code' => 100,
                        'status' => 'Succès',
                        'message' => MessageService::code100()
                    ]
                );
            }else{
                return response()->json(
                    [
                        'code' => 400,
                        'status' => 'Erreur',
                        'message' => MessageService::code400()
                    ]
                );
            }
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'Erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
// ======= =========== COMMENT DEVENIR EXPERT... =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== SOUMETTRE DOCUMENT =========== ======= //
    public function index_somettre_dossier(){
        try {
            $list = SoumettreDocsModel::Join('admin_account_models', 'soumettre_docs_models.author_id', '=', 'admin_account_models.id')
            ->select('admin_account_models.*', 'admin_account_models.id as user_id', 'soumettre_docs_models.*')->get();
            if($list != null){return $list;}
            else{return $list = [];}
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
    public function store_somettre_dossier(Request $request){
        try {

            // return $request->all();
            if(empty($request->author_id)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('auteur')
                    ]
                );
            endif;
            if(empty($request->libelle)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('libellé')
                    ]
                );
            endif;
            if(empty($request->description)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('description')
                    ]
                );
            endif;

            $add = new SoumettreDocsModel();
            $add->author_id = $request->author_id;
            $add->libelle = $request->libelle;
            $add->subTitle = $request->subTitle;
            $add->code_ref = SlgGenrateService::generateCodeRef();
            $add->description = $request->description;
            if(!empty($request->illustration)):
                $add->illustration = UploadFileService::uploadFile($request, 'illustration', 'docs');
            else:
                $add->illustration = null;
            endif;
            $add->slug = SlgGenrateService::slgGenerate();

            if($add->save()){
                return response()->json(
                    [
                        'status' => 'Succès',
                        'code' => 100,
                        'data' => $add->code_ref,
                        'message' => MessageService::code100()
                    ]
                );
            }
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'Erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
    public function update_somettre_dossier(Request $request, $slg){
        try {
            if(isset($slg)){

                if(empty($request->author_id)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('auteur')
                        ]
                    );
                endif;
                if(empty($request->libelle)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('libellé')
                        ]
                    );
                endif;
                if(empty($request->description)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('description')
                        ]
                    );
                endif;

                $data = SoumettreDocsModel::Where('slug', '=', $slg)->first();
                if($data){
                    $data->author_id = $request->author_id;
                    $data->libelle = $request->libelle;
                    $data->subTitle = $request->subTitle;
                    $data->description = $request->description;
                    if(!empty($request->illustration)):
                        $data->illustration = UploadFileService::uploadFile($request, 'illustration', 'docs');
                    else:
                        $data->illustration = null;
                    endif;
                    if($data->save()){
                        return response()->json(
                            [
                                'status' => 'Succès',
                                'code' => 200,
                                'message' => MessageService::code200(),
                            ]
                        );
                    };
                }else{
                    return response()->json(
                        [
                            'status' => 'Erreur',
                            'code' => 400,
                            'message' => MessageService::code400(),
                        ]
                    );
                }
            }else{
                return response()->json(
                    [
                        'code' => 300,
                        'status' => 'Erreur',
                        'message' => MessageService::code300()
                    ]
                );
            }
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'erreur',
                    'code' => 300,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
    public function delete_somettre_dossier($slg){
        try {
            if(!isset($slg)):
                return response()->json(
                    [
                        'code' => 300,
                        'status' => 'Erreur',
                        'message' => MessageService::code300()
                    ]
                );
            endif;
            $resp = SoumettreDocsModel::where('slug', '=', $slg)->delete();
            if($resp){
                return response()->json(
                    [
                        'code' => 100,
                        'status' => 'Succès',
                        'message' => MessageService::code100()
                    ]
                );
            }else{
                return response()->json(
                    [
                        'code' => 400,
                        'status' => 'Erreur',
                        'message' => MessageService::code400()
                    ]
                );
            }
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'Erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
// ======= =========== SOUMETTRE DOCUMENT =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== SOUMETTRE DOCUMENT =========== ======= //
    public function index_calculator_frais(){
        try {
            $list = CalculatorFraisModel::Join('admin_account_models', 'calculator_frais_models.author_id', '=', 'admin_account_models.id')
            ->select('admin_account_models.*', 'admin_account_models.id as user_id', 'calculator_frais_models.*')->get();
            if($list != null){return $list;}
            else{return $list = [];}
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
    public function store_calculator_frais(Request $request){
        try {

            // return $request->all();
            if(empty($request->author_id)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('auteur')
                    ]
                );
            endif;
            if(empty($request->libelle)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('libellé')
                    ]
                );
            endif;
            if(empty($request->description)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('description')
                    ]
                );
            endif;

            $add = new CalculatorFraisModel();
            $add->author_id = $request->author_id;
            $add->libelle = $request->libelle;
            $add->subTitle = $request->subTitle;
            $add->type_service_code = $request->type_service_code;
            $add->code_ref = SlgGenrateService::generateCodeRef();
            $add->description = $request->description;
            if(!empty($request->illustration)):
                $add->illustration = UploadFileService::uploadFile($request, 'illustration', 'docs');
            else:
                $add->illustration = null;
            endif;
            $add->slug = SlgGenrateService::slgGenerate();

            if($add->save()){
                return response()->json(
                    [
                        'status' => 'Succès',
                        'code' => 100,
                        'data' => $add->code_ref,
                        'message' => MessageService::code100()
                    ]
                );
            }
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'Erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
    public function update_calculator_frais(Request $request, $slg){
        try {
            if(isset($slg)){

                if(empty($request->author_id)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('auteur')
                        ]
                    );
                endif;
                if(empty($request->libelle)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('libellé')
                        ]
                    );
                endif;
                if(empty($request->description)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('description')
                        ]
                    );
                endif;

                $data = CalculatorFraisModel::Where('slug', '=', $slg)->first();
                if($data){
                    $data->author_id = $request->author_id;
                    $data->libelle = $request->libelle;
                    $data->subTitle = $request->subTitle;
                    $data->type_service_code = $request->type_service_code;
                    $data->description = $request->description;
                    if(!empty($request->illustration)):
                        $data->illustration = UploadFileService::uploadFile($request, 'illustration', 'docs');
                    else:
                        $data->illustration = null;
                    endif;
                    if($data->save()){
                        return response()->json(
                            [
                                'status' => 'Succès',
                                'code' => 200,
                                'message' => MessageService::code200(),
                            ]
                        );
                    };
                }else{
                    return response()->json(
                        [
                            'status' => 'Erreur',
                            'code' => 400,
                            'message' => MessageService::code400(),
                        ]
                    );
                }
            }else{
                return response()->json(
                    [
                        'code' => 300,
                        'status' => 'Erreur',
                        'message' => MessageService::code300()
                    ]
                );
            }
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'erreur',
                    'code' => 300,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
    public function delete_calculator_frais($slg){
        try {
            if(!isset($slg)):
                return response()->json(
                    [
                        'code' => 300,
                        'status' => 'Erreur',
                        'message' => MessageService::code300()
                    ]
                );
            endif;
            $resp = CalculatorFraisModel::where('slug', '=', $slg)->delete();
            if($resp){
                return response()->json(
                    [
                        'code' => 100,
                        'status' => 'Succès',
                        'message' => MessageService::code100()
                    ]
                );
            }else{
                return response()->json(
                    [
                        'code' => 400,
                        'status' => 'Erreur',
                        'message' => MessageService::code400()
                    ]
                );
            }
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'Erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
// ======= =========== SOUMETTRE DOCUMENT =========== ======= //
// ======= END =========== ======= //


// ======= START =========== ======= //
// ======= =========== DOCUMENT JOIN =========== ======= //
    public function document_join_by_code_ref($code_ref){
        try {
            if(isset($code_ref)):
                $list = DocumentJoin::Join('admin_account_models', 'document_joins.author_id', '=', 'admin_account_models.id')
                ->where('document_joins.code_ref_libelle', '=', $code_ref)
                ->select('admin_account_models.*', 'admin_account_models.id as user_id', 'document_joins.*')->get();

                if($list != null ){
                    return $list;
                }else{return [];}
            else:
                return response()->json(
                    [
                        'status' => 'Erreur',
                        'code' => 400,
                        'message' => MessageService::code400(),
                    ]
                );
            endif;
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
    public function index_document_join(){
        try {
            $list = DocumentJoin::Join('admin_account_models', 'document_joins.author_id', '=', 'admin_account_models.id')
            ->select('admin_account_models.*', 'admin_account_models.id as user_id', 'document_joins.*')->get();
            if($list != null){return $list;}
            else{return $list = [];}
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
    public function store_document_join(Request $request){
        try {
            if(empty($request->libelle_document)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('libellé de document')
                    ]
                );
            endif;
            if(empty($request->code_ref_libelle)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('référence')
                    ]
                );
            endif;
            if(empty($request->illustration)):
                return response()->json(
                    [
                        'code' => 302,
                        'status' => 'Erreur',
                        'message' => MessageService::code302('illustration')
                    ]
                );
            endif;

            $add = new DocumentJoin();
            $add->author_id = $request->author_id;
            $add->title = $request->title;
            $add->code_ref_libelle = $request->code_ref_libelle;
            $add->libelle_document = $request->libelle_document;
            if(!empty($request->illustration)):
                $add->illustration = UploadFileService::uploadFileAny($request, 'docs', 'join_', 'illustration');
            else:
                $add->illustration = null;
            endif;
            $add->slug = SlgGenrateService::slgGenerate();

            if($add->save()){
                return response()->json(
                    [
                        'status' => 'Succès',
                        'code' => 100,
                        'message' => MessageService::code100()
                    ]
                );
            }
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'Erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
    public function update_document_join(Request $request, $slg){
        try {
            if(isset($slg)){
                if(empty($request->libelle_document)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('libellé de document')
                        ]
                    );
                endif;
                if(empty($request->code_ref_libelle)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('référence')
                        ]
                    );
                endif;
                if(empty($request->illustration)):
                    return response()->json(
                        [
                            'code' => 302,
                            'status' => 'Erreur',
                            'message' => MessageService::code302('illustration')
                        ]
                    );
                endif;

                $data = DocumentJoin::Where('slug', '=', $slg)->first();
                if($data){
                    $data->author_id = $request->author_id;
                    $data->title = $request->title;
                    $data->code_ref_libelle = $request->code_ref_libelle;
                    $data->libelle_document = $request->libelle_document;
                    if(!empty($request->illustration)):
                        $data->illustration = UploadFileService::uploadFileAny($request, 'docs', 'join_', 'illustration');
                    else:
                        $data->illustration = null;
                    endif;
                    if($data->save()){
                        return response()->json(
                            [
                                'status' => 'Succès',
                                'code' => 200,
                                'message' => MessageService::code200(),
                            ]
                        );
                    };
                }else{
                    return response()->json(
                        [
                            'status' => 'Erreur',
                            'code' => 400,
                            'message' => MessageService::code400(),
                        ]
                    );
                }
            }else{
                return response()->json(
                    [
                        'code' => 300,
                        'status' => 'Erreur',
                        'message' => MessageService::code300()
                    ]
                );
            }
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'erreur',
                    'code' => 300,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
    public function delete_document_join($slg){
        try {
            if(!isset($slg)):
                return response()->json(
                    [
                        'code' => 300,
                        'status' => 'Erreur',
                        'message' => MessageService::code300()
                    ]
                );
            endif;
            $resp = DocumentJoin::where('slug', '=', $slg)->delete();
            if($resp){
                return response()->json(
                    [
                        'code' => 100,
                        'status' => 'Succès',
                        'message' => MessageService::code100()
                    ]
                );
            }else{
                return response()->json(
                    [
                        'code' => 400,
                        'status' => 'Erreur',
                        'message' => MessageService::code400()
                    ]
                );
            }
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => 'Erreur',
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
// ======= =========== DOCUMENT JOIN =========== ======= //
// ======= END =========== ======= //


}
