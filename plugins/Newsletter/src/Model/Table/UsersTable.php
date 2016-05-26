<?php
namespace Newsletter\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Newsletter\Model\Entity\User;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Logs
 * @property \Cake\ORM\Association\BelongsToMany $MailingLists
 */
class UsersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('users');
        $this->displayField('full_name_email');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Logs', [
            'foreignKey' => 'user_id',
            'className' => 'Newsletter.Logs'
        ]);
        $this->belongsToMany('MailingLists', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'mailing_list_id',
            'joinTable' => 'mailing_lists_users',
            'className' => 'Newsletter.MailingLists'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmpty('first_name');

        $validator
            ->allowEmpty('last_name');

        $validator
            ->requirePresence('locale', 'create')
            ->notEmpty('locale');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        return $rules;
    }

    public function findWithFullName(Query $query, array $options){


        return $query->select(['full_name' => $query->func()->concat(
            [
                'first_name' => 'identifier', ' ','last_name' => 'identifier'
            ])
        ]);
    }

    /**
     *
     * Returns all the users after matching their full name to a provided strings
     *
     * @param Query $query
     * @param array $options
     */
    public function findByFullName(Query $query, array $options){

        $match = $options['name'];
        return $query->where(function ($exp, $query) use ($match) {
            return $exp->like($this->buildFullName($query), "%$match%");
        });

    }

    public function findOrderByFullName(Query $query, array $options){

        return $query->orderDesc($this->buildFullName($query));

    }

    protected function buildFullName($query){

        return $query->func()->concat(['first_name' => 'identifier', 'last_name' => 'identifier']);

    }


}
