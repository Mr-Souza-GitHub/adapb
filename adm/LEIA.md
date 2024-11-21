Para usar os comandos de conexão com o PostgreSQL através do XAMPP, é necessário ativar as extensões referentes à ele nas configurações do APACHE. Caso contrário, um erro será exibido dizendo que foram utilizadas funções desconhecidas.

1. Abra o XAMPP Control Panel
2. Na seção do APACHE, clique em "Config"
3. Pesquise por "pgsql" (Pode-se usar a função de localização com Ctrl+F)
4. Retire o ";" (ponto e vírgura) do inicio de ambas as aparições da pesquisa. (O ; indica um comentário, ou seja, deixando desativadas as extensões.)
5. Salve o arquivo (Ctrl+S)
6. Agora inicie o APACHE e os comandos serão executados normalmente.