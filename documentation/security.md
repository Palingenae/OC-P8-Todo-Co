# Sécurité de Todo&Co

## Contexte
La sécurité de Todo&Co, dans son MVP revu, fonctionne de la façon telle que la documentation du framework Symfony le précise, et telle que l'entreprise Sensiolabs souhaite que cela fonctionne.

## Implémentation dans le projet

La documentation en question :
- [Documentation générale](https://symfony.com/doc/5.4/index.html)
- [Documentation spécifique à la sécurité](https://symfony.com/doc/5.4/security.html#access-control-authorization)

Si on devait résumer, la sécurité de Symfony fonctionne sur la base des rôles des utilisateur·ice·s, des voters, des mots de passe et des usernames avec pour base l'Entité User.

### L'entité User
C'est une classe sur laquelle repose une grande majorité de la sécurité au sein de Symfony. Si on devait garder le plus important en ce qui concerne garder l'entité à son minimum pour la sécurité, l'entité `User` se résumerait de cette façon :

```php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

// Il est important que l'entité implémente ces Interfaces, sinon cela ne fonctionnera pas.
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    private int $id;

    private string $username;

    private string $password;

    private array $roles = [];

    private string $email;

    // plus bas, les getters et setters pour l'encapsulation avec des propriétés privées.
}
```

C'est le strict minimum. Par ailleurs, il est aussi possible de modifier dans `config/packages/security.yml` de quelle façon seront identifiés les comptes utilisateurs ; selon la propriété email ou username.

### Les Rôles

Tel que vu précédemment, il existe dans l'entité User une propriété, de type Array (obligatoirement un Array sinon ça ne fonctionnera pas), qui consiste à contenir les rôles. Cela peut être appliqué dans chacun des cas de figure de l'utilisation de votre application.

Ces rôles permettent de déterminer quels rôles ont accès à quelle partie de l'application. Cela peut se révéler très pratique de définir des hiérarchies, comme ça, une personne administratrice aura aussi les mêmes droits que les personnes utilisateurs, mais avec bien plus de droits.

Voici par exemple tel que c'est que cela est défini dans le projet. Il existe d'autres clés dans ce fichier.
```yml
security:
    # ... `config/packages/security.yml`
    role_hierarchy:
        ROLE_ADMIN: ROLE_USER
    access_control:
        - { path: ^/admin, roles: ROLE_ADMIN }
        - { path: ^/profile, roles: ROLE_USER }
```

### Les Voters

Les voters sont des classes qui vont "voter" sur des critères des utilisateurs voulant accéder à telle partie de l'application, ou d'effectuer une actionb selon des critères spécifiques. Par exemple, dans `src/Security/Voters/TaskVoter.php` :

```php
protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var Task $subject */
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::PERSIST:
                // "Si l'utilisateur est strictement un admin OU si l'auteur de la tâche est bien celui qui est connecté"
                if (['ROLE_ADMIN'] == $user->getRoles() || $user === $subject->getUser()) {
                    return true;
                }
                break;
            case self::VIEW:
                if (['ROLE_ADMIN'] == $user->getRoles() || $user === $subject->getUser()) {
                    return true;
                }
                break;
            case self::DELETE:
                // "Si l'utilisateur est strictement Administrateur et qu'il n'y a pas d'utilisateur"
                if (['ROLE_ADMIN'] == $user->getRoles() && null === $subject->getUser()) {
                    return true;
                }
                break;
        }

        return false;
    }
```

On va déterminer si seuls les administrateurs ou les auteur·ice·s ont le droit "persister" (Créer ou Mettre à jour) une tâche pour les deux premiers cas du switch case. Pour le dernier cas, seulement un·e admin si la tâche n'est relié à aucun·e auteur·ice.

Important ! Chaque voteur doit avoir sa propre responsabilité ou son propre cas de figure. Ce cas ne parle que de la modification d'une tâche.