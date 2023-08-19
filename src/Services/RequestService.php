<?php

namespace Potelo\NfseSsa\Services;

use Potelo\NfseSsa\MySoapClient;
use Potelo\NfseSsa\Request\Error;
use Potelo\NfseSsa\Request\Response;

class RequestService
{
    /**
     * @var string
     */
    public $certificatePrivate;

    /**
     * @var string
     */
    private $urlBase;

    /**
     * @var array
     */
    private $soapOptions;

    public function __construct()
    {
        if (config('nfse-ssa.homologacao') == true) {
            $this->urlBase = 'http://nfse.pmfi.pr.gov.br';
        } else {
            $this->urlBase = 'http://nfse.pmfi.pr.gov.br';
        }

        $this->certificatePrivate = config('nfse-ssa.certificado_privado_path');

        $context = stream_context_create([
            'ssl' => [
                // set some SSL/TLS specific options
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ]);

        $this->soapOptions = [
            'keep_alive' => true,
            'trace' => true,
            'local_cert' => $this->certificatePrivate,
            'cache_wsdl' => WSDL_CACHE_NONE,
            'stream_context' => $context,
        ];
    }

    /**
     * @param $wsdlSuffix
     * @param $xml
     * @param $method
     * @param $return
     * @return Response
     */
    private function consult($wsdlSuffix, $xml, $method, $return)
    {
        $wsdl = $this->urlBase.$wsdlSuffix;

        $client = new MySoapClient($wsdl, $this->soapOptions);

        $params = new \SoapVar($xml, XSD_ANYXML);

        $result = call_user_func_array([$client, $method], [$params]);

        $xmlObj = simplexml_load_string($result->{$return}->any);

        $response = new Response();

        if (isset($xmlObj->ListaMensagemRetorno)) {
            $response->setStatus(false);

            foreach ($xmlObj->ListaMensagemRetorno->MensagemRetorno as $mensagem) {
                $error = new Error();

                $arr = get_object_vars($mensagem);

                $error->codigo = $arr['Codigo'];
                $error->mensagem = $arr['Mensagem'];
                $error->correcao = $arr['Correcao'];
                $response->addError($error);
            }
        } else {
            $response->setStatus(true);

            $json = json_encode($xmlObj);
            $data = json_decode($json, true);

            $response->setData($data);
        }

        return $response;
    }

    /**
     * @param $xml
     * @param $mainTagName
     * @return string
     */
    private function generateXmlBody($xml, $mainTagName, $subTagName)
    {
        return "
            <$mainTagName xmlns='http://tempuri.org/'>
                <$subTagName>
                    $xml
                </$subTagName>
            </$mainTagName>
        ";
    }

    /**
     * @param $xml
     * @return Response
     */
    public function validarLoteRps($xml)
    {
        $wsdlSuffix = '/nfsews/nfse.asmx?wsdl';

        $finalXml = $this->generateXmlBody($xml, 'ValidarLoteRPS', 'outterXml');

        $response = $this->consult(
            $wsdlSuffix,
            $finalXml,
            'ValidarLoteRPS',
            'ValidarLoteRPSResult'
        );

        return $response;
    }

    /**
     * @param $xml
     * @return Response
     */
    public function enviarLoteRps($xml)
    {
        $wsdlSuffix = '/nfsews/nfse.asmx?wsdl';

        $finalXml = $this->generateXmlBody($xml, 'RecebeLoteRPS', 'xml');

        $response = $this->consult(
            $wsdlSuffix,
            $finalXml,
            'RecebeLoteRPS',
            'RecebeLoteRPSResult'
        );

        return $response;
    }

    /**
     * @param $xml
     * @return Response
     */
    public function consultarSituacaoLoteRps($xml)
    {
        $wsdlSuffix = '/nfsews/nfse.asmx?wsdl';

        $finalXml = $this->generateXmlBody($xml, 'ConsultarSituacaoLoteRPS', 'xml');

        $response = $this->consult(
            $wsdlSuffix,
            $finalXml,
            'ConsultarSituacaoLoteRPS',
            'ConsultarSituacaoLoteRPSResult'
        );

        return $response;
    }

    /**
     * @param $xml
     * @return Response
     */
    public function consultarLoteRps($xml)
    {
        $wsdlSuffix = '/nfsews/nfse.asmx?wsdl';

        $finalXml = $this->generateXmlBody($xml, 'ConsultarLoteRPS', 'xml');

        $response = $this->consult(
            $wsdlSuffix,
            $finalXml,
            'ConsultarLoteRPS',
            'ConsultarLoteRPSResult'
        );

        return $response;
    }

    /**
     * @param $xml
     * @return Response
     */
    public function consultarNfseRps($xml)
    {
        $wsdlSuffix = '/nfsews/nfse.asmx?wsdl';

        $finalXml = $this->generateXmlBody($xml, 'ConsultarNfseRPS', 'xml');

        $response = $this->consult(
            $wsdlSuffix,
            $finalXml,
            'ConsultarNfseRPS',
            'ConsultarNfseRPSResult'
        );

        return $response;
    }

    public function consultarNfse($xml)
    {
        $wsdlSuffix = '/nfsews/nfse.asmx?wsdl';

        $finalXml = $this->generateXmlBody($xml, 'ConsultarNfse', 'xml');

        $response = $this->consult(
            $wsdlSuffix,
            $finalXml,
            'ConsultarNfse',
            'ConsultarNfseResult'
        );

        return $response;
    }
}
