<?php

namespace Potelo\NfseSsa;

use Potelo\NfseSsa\Services\RequestService;
use Potelo\NfseSsa\Services\SignatureService;

class NfseSsa
{
    private $signatureService;

    private $requestService;

    public function __construct(SignatureService $signatureService, RequestService $requestService)
    {
        $this->signatureService = $signatureService;

        $this->requestService = $requestService;
    }

    /**
     * @param $dados
     *
     * @return
     *
     * @throws \Throwable
     */
    public function validarLoteRps($dados)
    {
        $xml = xml_view('ValidarLoteRPS', $dados);

        $signedXml = $this->signatureService->signXml($xml, true, ['Rps']);

        $result = $this->requestService->validarLoteRps($signedXml);

        return $result;
    }

    /**
     * @param $dados
     *
     * @return
     *
     * @throws \Throwable
     */
    public function enviarLoteRps($dados)
    {
        $xml = xml_view('EnviarLoteRPS', $dados);

        $signedXml = $this->signatureService->signXml($xml, true, ['Rps']);

        $result = $this->requestService->enviarLoteRps($signedXml);

        return $result;
    }

    /**
     * @param $dados
     *
     * @return
     *
     * @throws \Throwable
     */
    public function consultarSituacaoLoteRps($dados)
    {
        $xml = xml_view('ConsultarSituacaoLoteRPS', $dados);

        $result = $this->requestService->consultarSituacaoLoteRps($xml);

        return $result;
    }

    /**
     * @param $dados
     *
     * @return
     *
     * @throws \Throwable
     */
    public function consultarLoteRps($dados)
    {
        $xml = xml_view('ConsultarLoteRPS', $dados);

        $result = $this->requestService->consultarLoteRps($xml);

        return $result;
    }

    /**
     * @param $dados
     *
     * @return
     *
     * @throws \Throwable
     */
    public function consultarNfseRps($dados)
    {
        $xml = xml_view('ConsultarNfseRPS', $dados);

        $result = $this->requestService->consultarNfseRps($xml);

        return $result;
    }

    /**
     * @param $dados
     * @return mixed
     * @throws \Throwable
     */
    public function consultarNfse($dados)
    {
        $xml = xml_view('ConsultarNfse', $dados);

        $result = $this->requestService->consultarNfse($xml);

        return $result;
    }

    /**
     * @param $dados
     * @return mixed
     * @throws \Throwable
     */
    public function cancelarNfse($dados)
    {
        $xml = xml_view('CancelarNfse', $dados);

        $signedXml = $this->signatureService->signXml($xml, true, ['Pedido']);

        $result = $this->requestService->cancelarNfse($signedXml);

        return $result;
    }
}
