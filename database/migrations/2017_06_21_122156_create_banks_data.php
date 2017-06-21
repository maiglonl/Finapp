<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Migrations\Migration;
use Finapp\Repositories\BankRepository;

class CreateBanksData extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        $repository = app(BankRepository::class);
        foreach ($this->getData() as $bankArray) {
            $repository->create($bankArray);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        $repository = app(BankRepository::class);
        $banks = $repository->all();
        foreach ($this->getData() as $bankArray) {
            $bank = $repository->findByField('name', $bankArray['name'])->first();
            $dest = \Finapp\Models\Bank::logosDir();
            \Storage::disk('public')->delete($dest.'/'.$bank->logo);
        }
    }

    public function getData(){
        return [
            [
                'name' => 'Banco do Brasil',
                'logo' => new UploadedFile(storage_path('app/files/banks/logos/banco_do_brasil.png'), 'banco_do_brasil.png')
            ],
            [
                'name' => 'Banrisul',
                'logo' => new UploadedFile(storage_path('app/files/banks/logos/banrisul.png'), 'banrisul.png')
            ],
            [
                'name' => 'Bradesco',
                'logo' => new UploadedFile(storage_path('app/files/banks/logos/bradesco.png'), 'bradesco.png')
            ],
            [
                'name' => 'Caixa',
                'logo' => new UploadedFile(storage_path('app/files/banks/logos/caixa.png'), 'caixa.png')
            ],
            [
                'name' => 'Itaú',
                'logo' => new UploadedFile(storage_path('app/files/banks/logos/itau.png'), 'itau.png')
            ],
            [
                'name' => 'Santander',
                'logo' => new UploadedFile(storage_path('app/files/banks/logos/santander.png'), 'santander.png')
            ],
            [
                'name' => 'Sicredi',
                'logo' => new UploadedFile(storage_path('app/files/banks/logos/sicredi.png'), 'sicredi.png')
            ]
        ];
    }
}
