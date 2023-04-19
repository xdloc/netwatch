<?php

namespace App\Console\Commands;

use App\Exceptions\InconsistentValueObjectException;
use App\Exceptions\InvestigationFailedException;
use App\Police\CredentialsPolice;
use App\Police\CredentialsPoliceAssembler;
use App\Police\NineOneOneOperator;
use App\ValueObjects\CustomerCode;
use Illuminate\Console\Command;

class InvestigateCredentialsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'investigate:credentials {customerCode?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan websites to check credentials changes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        try {
            if ($this->argument('customerCode') === null) {
                $customerCode = $this->ask('Please, enter customer code:');
            } else {
                $customerCode = $this->argument('customerCode');
            }
            $customerCode = new CustomerCode($customerCode);
            $this->info('Starting investigation...');

            /** @var CredentialsPolice $police */
            $police = (new NineOneOneOperator())->assemble(new CredentialsPoliceAssembler(), $customerCode);
            $police->investigate();
        } catch (InconsistentValueObjectException $exception) {
            $this->error($exception->getMessage());
            if ($exception->getValueObject() instanceof CustomerCode) {
                $this->call('investigate:credentials');
            }
        } catch (InvestigationFailedException $exception) {
            $this->error($exception->getMessage());
            return self::FAILURE;
        }


        /*$client = new Client();
        $crawler = $client->request('GET', 'https://pokras-lampas.com/public_offer/');
        //Xpath //*[@id="content"]/div/Investdiv/div[1]/table/tbody/tr/td[1]/p[2]
        //selector #content > div > div > div.descror > table > tbody > tr > td.td1 > p:nth-child(2)
        var_dump($crawler->filter('#content > div > div > div.descror > table > tbody > tr')->each(function ($node) {
            print $node->text() . "\n // ";
        }));*/
        return self::SUCCESS;
    }
}
