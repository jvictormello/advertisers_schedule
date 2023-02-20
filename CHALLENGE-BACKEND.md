#### Desafio 🚀

O desafio consiste em desenvolver uma Application Programming Interface (API) de um sistema de locação de imóveis.

Fique à vontade para montar a estrutura do banco conforme você desejar.

Para facilitar o desenvolvimento, crie seeders.

A API deverá ter os seguintes endpoints:
- Listar imóveis;
- Visualizar imóvel específico;
- Gerenciamento de imóveis
- Realizar Locação;
- Cancelar Locação;
- Iniciar estadia;
- Finalizar estadia;

A listagem de imóveis podemos realizar filtros por quantidade máxima de pessoas ou valores;

O locatário pode ver as informações de um imóvel e os dias disponíveis para a locação.
Essas informações devem ser cacheadas em 3 minutos

O locador pode cadastrar seus imóveis e possui algumas informações obrigatórias como o CEP, descrição e características, valor/diária, quantidade máxima de pessoal e também a quantidade mínima de dias para locação.

O CEP deve ser validado através de uma comunicação externa com a API do Brasil API.
Essa comunicação externa deve estar protegida através do pacote do Circuit Breaker.

Tanto o locatário como o locador podem acessar um histórico de locações através da tabelalocations. 
Esta tabela possui alguns campos como obrigatórios, como: id do imóvel, id dolocador, período e preço final. 

Sinta-se à vontade para adicionar outras informações

Caso o locatário não queira mais locar o imóvel, ele pode realizar o cancelamento antes dadata prevista, 
também deve ser emitida uma job notificando o locador sobre o cancelamento de locação.

No agendamento da locação, devem ser enviadas as seguintes informações: 
Quantidade de pessoas, período desejado e identificação do imóvel;

Caso não seja trabalhada a autenticação, realizar o envio do id do locatário como parâmetro;


As locações terão por padrão um status que será alterado conforme o processo de locação

A finalização da estadia pode ser realizada antes da data esperada para saída.

Fique à vontade para montar algumas estruturas do banco e outras regras de negócio conforme você desejar.

Fique a vontade para realização e desenvolvimento de seeders

#### Extras 🕹

- Autenticação JWT
- Documentação da API
- Configuração do Redis, para utilização de cache

#### É obrigatório ⚠

- Os retornos da API deve ser JSON
- Testes unitários são obrigatórios
- Priorizar a utilização de recursos nativos do framework Laravel, Form requests, helpers e etc
- Utilizar interfaces para as camadas de *Service* e *Repository*
- Use e abuse de princípios de boas práticas de programação, Código limpo, S.O.L.I.D, DRY e KISS

#### É importante saber 🧠

- Classes: utilizar o padrão camelCase, porém com a primeira letra Maiúscula, também conhecido como UpperCamelCase ex: NomeDaClasse
- Métodos e variáveis: utilizar o padrão camelCase
- Migrations: (nome de campos), utilizar o padrão snake_case
- Nome de arquivos de migrations e tabelas: utilizar snake_case, no plural
- Rotas: utilizar o padrão kebab-case (exceto o parâmetro), ex: users/example-kebabs/{userId}
- Atentar as PSR’s: https://www.php-fig.org/
- Seguir as padronizações de Gitflow (baseado no nosso contexto) e padrão de mensagens utilizando conventional commits. https://www.conventionalcommits.org/en/v1.0.0/

<br> 

---

#### Durante o processo de ambientação é importante que: 📌

- Solicitação de revisão de PRs também deve ser solicitado no canal Back-End da turma, **turma-cate-XX-back-end**
- Aproveite o máximo o processo, não se preocupe em fazer códigos complexos, faça o simples. Evite se basear em códigos de Pull Requests anteriores, o ato dificulta a remoção de impedimentos e prejudica a identificação de pontos de melhorias.
- Não se esqueça, o objetivo da ambientação técnica é absorver o máximo possível de técnicas, padrões e conceitos que utilizamos hoje em nossos projetos. Então use nossos projetos como base.
- Lembre-se que o CATe é o primeiro time que você estará atuando na Atlas, o comportamento de equipe é esperado, se possível interaja com os colegas, auxilie e aprenda com eles. 

---
