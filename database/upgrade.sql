/**
 * Author:  Ephraim
 * Created: 23 Jul 2018
 */

ALTER TABLE beta_testing.account_groups
    ADD CONSTRAINT account_groups_id_primary PRIMARY KEY (id);

ALTER TABLE beta_testing.account_groups
    ADD CONSTRAINT account_groups_name_unique UNIQUE (name);
ALTER TABLE beta_testing.bank_account
    ADD CONSTRAINT bank_account_account_number_unique UNIQUE (account_number);